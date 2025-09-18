<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Conge;
use App\Models\User;
use Carbon\Carbon;

class CongeController extends Controller
{
    public function index()
    {
        $employees = User::where('role', 'employe')->orderBy('prenom')->get();
        $year = request()->input('year', now()->year);

        $conges = Conge::with('user')
            ->where(function($q) use ($year) {
                $q->whereYear('date_debut', $year)->orWhereYear('date_fin', $year);
            })
            ->orderBy('date_debut')
            ->get();

        $congesByMonth = $conges->groupBy(function($conge) {
            return Carbon::parse($conge->date_debut)->translatedFormat('F');
        });

        return view('admin.conges.index', compact('employees', 'congesByMonth', 'conges', 'year'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'type' => 'required|string',
            'statut' => 'required|in:Approuvé,En attente',
        ]);

        $conge = Conge::create($request->all());

        // Mise à jour immédiate du statut si le congé est approuvé et en cours
        if ($conge->statut == 'Approuvé' && Carbon::today()->between($conge->date_debut, $conge->date_fin)) {
            $conge->user->update(['statut' => 'En congé']);
        }

        return redirect()->route('admin.conges.index')->with('success', 'Congé planifié avec succès.');
    }

    public function destroy(Conge $conge)
    {
        // Remettre le statut à Actif si le congé supprimé était en cours
        if (Carbon::today()->between($conge->date_debut, $conge->date_fin)) {
            $conge->user->update(['statut' => 'Actif']);
        }
        $conge->delete();
        return redirect()->route('admin.conges.index')->with('success', 'Congé supprimé avec succès.');
    }
}
