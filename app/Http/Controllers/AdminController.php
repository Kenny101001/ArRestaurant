<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

use Intervention\Image\Facades\Image;

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

    public function home(Request $request)
    {
        $pageTitle = "Accueil";

        if (!Session::has('utilisateur')) {
            return redirect()->route('login')->withErrors(['error' => 'Votre session a expiré, veuillez vous reconnecter.']);
        }

        $forfaits = json_decode($this->getForfaits()->getContent());
        $typeEntreprises = json_decode($this->getTypeEntreprises()->getContent());

        return view('admin.index', compact('pageTitle', 'forfaits', 'typeEntreprises'));

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

            $documentPath = 'photoBase/entreprise.png';

            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $fileName = $validatedData['nom'] . '.webp';

                $img = Image::make($file->getPathname());
                $img->resize(null, 200, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $webpData = $img->encode('webp', 75);

                $documentPath = 'Entreprise/' . $validatedData['nom'] . '/' . 'logos/' . $fileName;

                if (Storage::disk('public')->exists($documentPath) && $documentPath !== 'photoBase/entreprise.png') {
                    Storage::disk('public')->delete($documentPath);
                }

                Storage::disk('public')->put($documentPath, $webpData);
            }

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
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Entreprise ajoutée avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

}
