<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployerRequest;
use App\Models\departement;
use App\Models\Employer;
use Illuminate\Http\Request;

class EmployerController extends Controller
{
    public function index()
    {
        $employers = Employer::latest()->paginate(5);
        return view('Employer.index', compact('employers'));
    }
    public function create()
    {
        $departements = departement::all();
        return view('Employer.create', compact(
            'departements'
        ));
    }

    public function store(EmployerRequest $request)
    {
        $employers = new Employer();
        $employers->nom = $request->name;
        $employers->prenom = $request->firstname;
        $employers->email = $request->email;
        $employers->telephone = $request->phone;
        $employers->departement_id = $request->departement;
        $employers->montant_journalier = $request->montant;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $employers->image = $filename;
        }
        $employers->save();
        return redirect()->route('employers.index')->with('success', 'Employé créé avec succès');
    }
    public function edit(Employer $employer)
    {
        $departements = departement::all();
        return view("Employer.edit", compact(
            'employer',
            'departements'
        ));
    }
    public function update(Employer $employer, Request $request)
    {
        $employer->nom = $request->name;
        $employer->prenom = $request->firstname;
        $employer->email = $request->email;
        $employer->telephone = $request->phone;
        $employer->departement_id = $request->departement;
        $employer->montant_journalier = $request->montant;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $employer->image = $filename;
        }
        $employer->save();
        return redirect()->route('employers.index')->with('success', 'Employé modifié avec succès');
    }
    public function destroy(Employer $employer)
    {
        $employer->delete();

        return redirect()->route('employers.index')->with('success', 'Employé supprimé avec succès');
    }
    public function search()
    {
        $search = request('search');
        $employers = Employer::where('nom', 'like', "%$search%")
            ->orWhere('prenom', 'like', "%$search%")
            ->orWhere('email', 'like', "%$search%")
            ->orWhere('telephone', 'like', "%$search%")
            ->orWhereHas('departement', function ($query) use ($search) {
                $query->where('nom', 'like', "%$search%");
            })
            ->latest()
            ->paginate(5);

        return view('Employer.index', compact('employers'));
    }
}
