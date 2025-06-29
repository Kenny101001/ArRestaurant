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

class AdminController extends Controller
{
    public function home(Request $request)
    {
        $pageTitle = "Accueil";

        if (!Session::has('utilisateur')) {
            return redirect()->route('login')->withErrors(['error' => 'Votre session a expiré, veuillez vous reconnecter.']);
        }

        return view('admin.index', compact('pageTitle'));

    }

    public function ajouterEntreprise(Request $request)
    {
        $request->validate([
            'utilisateur' => 'required|exists:utilisateur,id',
            'dateDebut' => 'required|date|before_or_equal:dateFin',
            'dateFin' => 'required|date|after_or_equal:dateDebut',
        ]);

        try {

            DB::table('conge')->insert([
                'idutilisateur' => $request->utilisateur,
                'date_debut' =>$request->dateDebut,
                'date_fin' =>$request->dateFin,
                'date_creation' => now(),
            ]);

            return redirect()->back()->with('success', 'Congé ajouté avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    }
}
