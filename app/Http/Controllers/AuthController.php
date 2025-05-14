<?php

namespace App\Http\Controllers;

use App\Http\Requests\HandleRequest;
use App\Http\Requests\loginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }
    public function handleregister(HandleRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('login')->with('success', 'Vous avez bien ete inscrite veuillez vous connecter');
    }

    public function login()
    {
        return view('auth.login');
    }
    public function handlelogin(Request $request)
    {

        $credentials = $request->validate([

            'email' => ['required', 'email'],

            'password' => ['required'],

        ]);



        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            return redirect()->route('dashboard');
        } else {
            return back()->with('error', 'email ou mot de passe incorrect');
        }
    }
    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect()->route('login');
    }
}
