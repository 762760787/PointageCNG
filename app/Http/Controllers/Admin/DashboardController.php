<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pointage;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $pointagesDuJour = Pointage::with('user')
            ->where('date', Carbon::today())
            ->get();

        return view('admin.dashboard', compact('pointagesDuJour'));
    }

    public function showQrCodes()
    {
        return view('admin.qrcodes');
    }

    public function rapports(Request $request)
    {
        // Logique pour filtrer et afficher les rapports
        $pointages = Pointage::with('user')->paginate(20);
        return view('admin.rapports', compact('pointages'));
    }

    public function export()
    {
        // Logique pour l'export CSV
    }


}