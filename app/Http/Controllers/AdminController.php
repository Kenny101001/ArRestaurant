<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Hash;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;


class AdminController extends Controller
{

    public function getForfaits()
    {
        $forfaits = DB::table('forfait')->get();
        return response()->json($forfaits);
    }

    public function getTypeEntreprises()
    {
        $typeEntreprises = DB::table('typeEntreprise')->get();
        return response()->json($typeEntreprises);
    }

    public function getEntreprises()
    {
        $entreprises = DB::table('v_entreprise_details')->get();
        return response()->json($entreprises);
    }

    public function home(Request $request)
    {
        $pageTitle = "Accueil";

        if (!Session::has('utilisateur')) {
            return redirect()->route('login')->withErrors(['error' => 'Votre session a expiré, veuillez vous reconnecter.']);
        }

        $forfaits = json_decode($this->getForfaits()->getContent());
        $typeEntreprises = json_decode($this->getTypeEntreprises()->getContent());
        $entreprises = json_decode($this->getEntreprises()->getContent());

        return view('admin.index', compact('pageTitle', 'forfaits', 'typeEntreprises','entreprises'));

    }

    public function ajouterEntreprise(Request $request)
    {

        Log::info('Requête reçue dans ajouterEntreprise', [
            'method' => $request->method(),
            'data' => $request->all()
        ]);


        $data = $request->all();

        DB::beginTransaction();

        if ($data['type'] === 'new') {
            $newTypeName = $request->input('new_typeEntreprise');

            $existingType = DB::table('typeEntreprise')->where('type', $newTypeName)->first();

            if ($existingType) {
                $data['type'] = $existingType->id;
            } else {
                $newTypeId = DB::table('typeEntreprise')->insertGetId([
                    'type' => $newTypeName,
                ]);
                $data['type'] = $newTypeId;
            }
        }

        $validator = Validator::make($data, [
            'nom' => 'string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg',
            'adresse' => 'nullable|string',
            'type' => 'exists:typeEntreprise,id',
            'phone' => 'string|unique:entreprise,phone',
            'email' => 'email|unique:entreprise,email',
            'website' => 'nullable|string',
            'forfait' => 'exists:forfait,id',
        ]);



        if ($validator->fails()) {
            $errors = [];

            if ($validator->errors()->has('nom')) {
                $errors[] = 'Le nom de l\'entreprise est obligatoire.';
            }

            if ($validator->errors()->has('adresse')) {
                $errors[] = 'L\'adresse est obligatoire.';
            }

            if ($validator->errors()->has('phone')) {
                $errors[] = 'Le numéro de téléphone est obligatoire et doit être unique.';
            }

            if ($validator->errors()->has('email')) {
                $errors[] = 'L\'email est obligatoire et doit être unique.';
            }

            if ($validator->errors()->has('type')) {
                $errors[] = 'Le type d\'entreprise est obligatoire.';
            }

            if ($validator->errors()->has('forfait')) {
                $errors[] = 'Le forfait est obligatoire.';
            }

            DB::rollBack();
            return redirect()->back()->withErrors($errors)->withInput();
        }

        $validatedData = $validator->validated();

        try {

            $documentPath = 'photoBase/entreprise.svg';

            if ($request->hasFile('logo')) {
                $file = $request->file('logo');

                $img = Image::make($file->getPathname());
                $img->resize(null, 200, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $fileName = $validatedData['nom'] . '.webp';
                $webpData = $img->encode('webp', 75);

                $documentPath = 'Entreprise/' . $validatedData['nom'] . '/' . 'logos/' . $fileName;

                if (Storage::disk('public')->exists($documentPath) && $documentPath !== 'photoBase/entreprise.png') {
                    Storage::disk('public')->delete($documentPath);
                }

                Storage::disk('public')->put($documentPath, $webpData);
            }

            $mdp = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 10);

            Mail::raw("Votre email de connexion est : $request->email \n Et votre mot de passe est : $mdp \n \n Ce mot de passe est unique, gardez la précieusement, \n
            Les informations privées sont cryptées dans nos base de données, seul vous y avez accès.", function ($message) use ($request) {
                $message->to($request->email)
                        ->subject('Code de connexion');
            });

            $mdpHash = Hash::make($mdp);

            DB::table('entreprise')->insert([
                'nom' =>$validatedData['nom'],
                'logo' => $documentPath,
                'adresse' => $validatedData['adresse'],
                'type_entreprise' => $validatedData['type'],
                'phone' => $validatedData['phone'],
                'email' => $validatedData['email'],
                'siteweb' => $validatedData['website'],
                'forfait' => $validatedData['forfait'],
                'date_ajout' => now(),
                'mdp' => $mdpHash
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Entreprise ajoutée avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function entrepriseDetail($id, Request $request)
    {
        $pageTitle = "Entreprise Détail";

        if (!Session::has('utilisateur')) {
            return redirect()->route('login')->withErrors(['error' => 'Votre session a expiré, veuillez vous reconnecter.']);
        }

        $entreprise = DB::table('v_entreprise_details')->where('id', $id)->first();

        // Log::info('Entreprise retrieved', ['id' => $entreprise->id, 'entreprise' => $entreprise]);

        if (!$entreprise) {
            return back()->withErrors(['entreprise' => 'Entreprise introuvable.']);
        }

        $produits = DB::table('v_produit_details')->where('id_entreprise', $entreprise->id)->get();

        $type_plats = DB::table('type_plat')->get();

        return view('admin.entrepriseDetail', compact('id','pageTitle', 'entreprise', 'produits','type_plats'));
    }

    public function ajouterObjet3d(Request $request)
    {

        $data = $request->all();

        DB::beginTransaction();

        if ($data['typePlat'] === 'new') {
            $newTypeName = $request->input('new_typePlat');

            $existingType = DB::table('type_plat')->where('nom', $newTypeName)->first();

            if ($existingType) {
                $data['typePlat'] = $existingType->id;
            } else {
                $newTypeId = DB::table('type_plat')->insertGetId([
                    'nom' => $newTypeName,
                ]);
                $data['typePlat'] = $newTypeId;
            }
        }

        $validator = Validator::make($data, [
            'apple3d' => 'required|array',
            'apple3d.*' => 'required|file',
            'entrepriseId' => 'required|exists:entreprise,id',
            'typePlat' => 'required|exists:type_plat,id'
        ]);

        // Log::info('Requête reçue dans ajouterObjet3d', ['data' => $data]);

        if ($validator->fails()) {
            $errors = [];

            if ($validator->errors()->has('apple3d.*')) {
                $errors[] = 'Les fichiers 3D sont obligatoires et doivent avoir l\'extension .usdz.';
            }

            if ($validator->errors()->has('entrepriseId')) {
                $errors[] = 'L\'ID de l\'entreprise est obligatoire.';
            }

            DB::rollBack();
            return back()->withErrors($errors)->withInput();
        }

        $entreprise = DB::table('v_entreprise_details')->where('id', $request->input('entrepriseId'))->first();

        $nb3d = DB::table('produit')->where('id_entreprise', $entreprise->id)->count();

        $newNb3d = $nb3d + count($request->file('apple3d'));

        // Log::info('Nombre de modèles 3D avant ajout', ['nb3d' => $nb3d, 'newNb3d' => $newNb3d]);

        if ($newNb3d > $entreprise->forfait_nb3d) {

            DB::rollBack();
            return back()->withErrors([
                'forfait' => "Il ne vous reste que " . ($entreprise->forfait_nb3d - $nb3d) . " modèles 3D disponibles."
            ]);
        }

        try {

            $typePlatName = DB::table('type_plat')->where('id', $data['typePlat'])->value('nom');

            foreach ($request->file('apple3d') as $key => $file) {

                $fileName = $file->getClientOriginalName();
                $cleanName = Str::slug(pathinfo($fileName, PATHINFO_FILENAME)) . '.usdz';

                $documentPath = 'Entreprise/' . Str::slug($entreprise->nom) . '/objets3d' .'/'. $typePlatName . '/' . $cleanName;

                if (Storage::disk('public')->exists($documentPath)) {
                    Storage::disk('public')->delete($documentPath);
                }

                Storage::disk('public')->put($documentPath, (string) $file);

                Log::info('Chemin sauvegarde : ' . $documentPath);

                do {
                    $code = Str::random(12);
                } while (DB::table('produit')->where('code', $code)->exists());


                DB::table('produit')->insert([
                    'id_entreprise' => $entreprise->id,
                    'nom' => $fileName,
                    'url_3d' => $documentPath,
                    'date_ajout' => now(),
                    'id_type_plat' => $data['typePlat'],
                    'code' => $code
                ]);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Objets 3D ajoutés avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

}
