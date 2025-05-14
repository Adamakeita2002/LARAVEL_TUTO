<?php

namespace App\Http\Controllers;

use App\Http\Requests\configrequest;
use App\Models\Configuration;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    public function index()
    {
        $configurations = Configuration::latest()->paginate(5);
        return view('configuration.index', compact('configurations'));
    }
    public function create()
    {
        return view('configuration.create');
    }
    public function store(Configuration $configuration, configrequest $request)
    {
        $configuration->type = $request->type;
        $configuration->value = $request->value;
        $configuration->save();
        return redirect()->route('configuration.index')->with('success', 'Configuration créée avec succès');
    }
    public function destroy(Configuration $configuration)
    {
        $configuration->delete();
        return redirect()->route('configuration.index')->with('success', 'Configuration supprimée avec succès');
    }
}
