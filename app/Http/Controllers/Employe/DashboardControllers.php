<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardControllers extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Cette ligne ne devrait plus être signalée par votre éditeur
        $pointageDuJour = $user->pointages()->where('date', Carbon::today())->first();

        return view('employe.dashboard', compact('pointageDuJour'));
    }

    // Renommé en "scanner" pour correspondre aux routes
    public function scanner()
    {
        return view('employe.scanner');
    }

    // Renommé en "historique" pour correspondre aux routes
    public function historique()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $pointages = $user->pointages()->latest()->take(7)->get();
        return view('employe.historique', compact('pointages'));
    }
}

