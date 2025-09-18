<?php
// app/Http/Controllers/Admin/JourFerieController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JourFerie;
use Illuminate\Http\Request;

class JourFerieController extends Controller
{
    public function index()
    {
        $joursFeries = JourFerie::orderBy('date', 'desc')->get();
        return view('admin.jours_feries.index', compact('joursFeries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'date' => 'required|date|unique:jours_feries,date',
        ]);
        JourFerie::create($request->all());
        return redirect()->route('admin.jours-feries.index')->with('success', 'Jour férié ajouté avec succès.');
    }

    public function destroy(JourFerie $jourFerie)
    {
        $jourFerie->delete();
        return redirect()->route('admin.jours-feries.index')->with('success', 'Jour férié supprimé avec succès.');
    }
}