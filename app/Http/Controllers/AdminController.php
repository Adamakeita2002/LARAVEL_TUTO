<?php

namespace App\Http\Controllers;

use App\Http\Requests\Adminrequest;
use App\Http\Requests\adminUpdateRequest;
use App\Http\Requests\validateaccountRequest;
use App\Models\ResetPassword;
use App\Models\User;
use App\Notifications\sendNotificationToAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    public function index()
    {
        $users = User::paginate(5);
        return view('admin.index', compact('users'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(User $user, Request $request)
    {


        try {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make("password");
            $code = rand(100000, 999999);
            $user->notify(new sendNotificationToAdmin($code, $request->email));
            ResetPassword::create([
                'email' => $request->email,
                'code' => $code,
            ]);
            $user->save();
            return redirect()->route('admin.create')->with('success', 'Admin créé avec succès. Un code de vérification a été envoyé à l\'adresse électronique.');
        } catch (\Exception $e) {
            return redirect()->route('admin.create')->with('error', 'Erreur lors de l\'envoi de la notification.');
        }
    }

    public function edit($id)
    {
        return view('admin.edit', compact('id'));
    }



    public function destroy(User $user)
    {

        $adminConnected = Auth::user()->id;
        if ($adminConnected == $user->id) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte ');
        } else {
            $user->delete();
            return redirect()->route('admin.index')->with('success', 'Admin supprimé avec succès.');
        }
    }


    public function validateaccount($email)
    {
        $checkUserExist = User::where('email', $email)->first();
        if ($checkUserExist) {
            return view('auth.validateAccountPage', compact('email',));
        } else {
            //route 404
        };
    }
    public function handlevalidateaccount(validateaccountRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        $code = ResetPassword::where('email', $request->email)->first();
        if ($user && $code) {
            if ($request->code == $code->code) {
                $user->password = Hash::make($request->password);
                $user->save();
                ResetPassword::where('email', $request->email)->delete();
                return redirect()->route('login')->with('success', 'Mot de passe mis à jour avec succès.');
            } else {
                return redirect()->back()->with('error', 'Le code est incorrect.');
            }
        } else {
            return redirect()->back()->with('error', 'L\'utilisateur n\'existe pas ou le code est incorrect.');
        }
    }
    public function show($id)
    {
        $user = User::find($id);
        // dd($user);
        return view('admin.show', compact('user'));
    }
    public function update(adminUpdateRequest $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move('images', $filename);
            $user->image = $filename;
        }
        $user->save();
        // return redirect()->back()->with('success', 'Admin mis à jour avec succès.');




        if (Hash::check($request->oldpassword, $user->password)) {
            $user->password = Hash::make($request->newpassword);
            $user->save();
            return redirect()->route('admin.index')->with('success', 'Mot de passe mis à jour avec succès.');
        } else {
            return redirect()->route('admin.index')->with('success', 'Admin mis à jour avec succès.');
        }
    }
    public function deleteaccount($email)
    {
        $user = User::where('email', $email)->first();
        if ($user && $user->id) {
            $user->delete();
            return redirect()->route('login')->with('success', 'Compte supprimé avec succès.');
        } elseif ($user->id != Auth::user()->id) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas supprimer ce compte.');
        } else {
            return redirect()->back()->with('error', 'Erreur lors de la suppression du compte.');
        }
    }
    public function search()
    {
        $search = request()->input('search');
        $users = User::where('name', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%')
            // ->orWhere('prenom', 'like', '%' . $search . '%')
            // ->orWhere('telephone', 'like', '%' . $search . '%')
            ->paginate(5);
        $users->appends(['search' => $search]);

        return view('admin.index', compact('users', 'search'));
    }
}
