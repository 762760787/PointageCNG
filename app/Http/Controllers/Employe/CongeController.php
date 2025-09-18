<?php
// app/Http/Controllers/Employe/CongeController.php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Conge;
use Illuminate\Support\Facades\Auth;

class CongeController extends Controller
{
    public function index()
    {
        $conges = Auth::user()->conges()->latest()->get();
        return view('employe.conges.index', compact('conges'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'type' => 'required|string',
            'motif' => 'nullable|string',
        ]);

        Auth::user()->conges()->create($request->all());
        return redirect()->route('employe.conges.index')->with('success', 'Demande de congé envoyée.');
    }
}

