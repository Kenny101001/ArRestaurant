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

class LoginController extends Controller
{
    public function login()
    {
        return view('identification.login');
    }

    public function loginVerifAdmin(Request $request)
    {
        $email = request()->input('email');
        $mdp = request()->input("mdp");

        $validator = Validator::make(request()->all(), [
            'email' => 'required|email',
            'mdp' => 'required|string',
        ]);

        if ($validator->fails()) {
            $errors = [];

            if ($validator->errors()->has('email')) {
                $errors[] = 'L\'email est obligatoire et doit être valide.';
            }

            if ($validator->errors()->has('mdp')) {
                $errors[] = 'Le mot de passe est obligatoire.';
            }

            return back()->withErrors($errors)->withInput();
        }

        $verifEmail = DB::table('utilisateur')->where('email', $email)->first();
        if (!$verifEmail) {
            return back()->withErrors(['email' => 'Ce Email est incorrect'])->withInput();
        }

        if ($verifEmail->mdp != $mdp) {
            return back()->withErrors(['mdp' => 'Ce mot de passe est incorrect'])->withInput();
        }

        $verif = DB::table('utilisateur')->where('email', $email)->first();

        Session::put('utilisateur', $verif);
        return redirect()->route('home');

    }

    public function loginVerify()
    {
        $email = request()->input('email');
        $mdp = request()->input("mdp");

        $validator = Validator::make(request()->all(), [
            'email' => 'required|email',
            'mdp' => 'required|string',
        ]);

        if ($validator->fails()) {
            $errors = [];

            if ($validator->errors()->has('email')) {
                $errors[] = 'L\'email est obligatoire et doit être valide.';
            }

            if ($validator->errors()->has('mdp')) {
                $errors[] = 'Le mot de passe est obligatoire.';
            }

            return back()->withErrors($errors)->withInput();
        }

        $verifEmail = DB::table('utilisateur')->where('email', $email)->first();
        if (!$verifEmail) {
            return back()->withErrors(['email' => 'Ce Email est incorrect'])->withInput();
        }

        if (!Hash::check($mdp, $verifEmail->mdp)) {
            return back()->withErrors(['mdp' => 'Ce mot de passe est incorrect'])->withInput();
        }

        $verif = DB::table('utilisateur')->where('email', $email)->first();

        Session::put('utilisateur', $verif);
        return redirect()->route('home');

    }

    public function deco()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('login');
    }
}
