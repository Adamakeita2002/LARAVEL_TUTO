<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartementRequest;
use App\Models\departement;
use Illuminate\Http\Request;

class DepartementController extends Controller
{
    public function index()
    {
        $departements = departement::paginate(5);
        return view('departement.index', compact('departements'));
    }
    public function create()
    {
        return view('departement.create');
    }
    public function store(DepartementRequest $request)
    {

        $departement = new departement();
        $departement->nom = $request->name;
        $departement->save();

        return redirect()->route('departement.index')->with('success', 'Departement creer avec succes');
    }
    public function edit(departement $departement)
    {
        return view('departement.edit', compact('departement'));
    }

    public function update(departement $departement, DepartementRequest $request)
    {

        $departement->nom = $request->name;
        $departement->save();
        return redirect()->route('departement.index')->with('success', 'Departement modifier avec succes');
    }
    public function destroy(departement $departement)
    {
        if ($departement->employer()->count() > 0) {
            return redirect()->route('departement.index')->with('error', 'Impossible de supprimer le departement car il contient des employés');
        } else {
            $departement->delete();
        }

        return redirect()->route('departement.index')->with('success', 'Departement supprimer avec succes');
    }
}
