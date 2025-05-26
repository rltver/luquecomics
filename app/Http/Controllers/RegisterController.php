<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function create(){
        return view('auth.register');
    }
    public function store(Request $request){
        //validate
        $validated = request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        //create the user
        $user = User::create($validated);
        //login
        Auth::login($user);
        $user->sendEmailVerificationNotification();

        //redirect
        return redirect(route('verification.notice'))->with('success', '¡Correo de verificación enviado!');
    }
}
