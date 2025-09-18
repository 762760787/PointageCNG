<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\Models\Pointage;
class DashboardControllers extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // --- CORRECTION DÉFINITIVE APPLIQUÉE ICI ---
        // Utilisation de 'whereDate' pour comparer uniquement la date, sans l'heure.
        // Cela garantit de trouver le pointage, peu importe à quelle heure il a été fait.
        $pointageDuJour = $user->pointages()->whereDate('date', Carbon::today())->first();

        return view('employe.dashboard', compact('pointageDuJour'));
    }

    public function scanner()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // On applique la même correction ici pour être cohérent.
        $pointageDuJour = $user->pointages()->whereDate('date', Carbon::today())->first();

        return view('employe.scanner', compact('pointageDuJour'));
    }

    /**
     * NEW: Displays a dedicated page for the check-in history.
     */
    public function historique()
    {
       /** @var \App\Models\User $user */
       $user = Auth::user();

       // Fetches the last 30 check-ins for the history page
       $historiquePointages = $user->pointages()->latest('date')->take(30)->get();

       // Returns to a new view dedicated to the history
       return view('employe.historique', compact('historiquePointages'));
    }

     /**
     * NEW: Displays the employee's profile page.
     */
    public function profil()
    {
        return view('employe.profil');
    }

    /**
     * NEW: Updates the employee's profile information.
     */
    public function updateProfil(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // --- CORRECTION APPLIQUÉE ICI ---
        $request->validate([
            'prenom' => ['required', 'string', 'max:255'], // Validation pour le prénom
            'nom' => ['required', 'string', 'max:255'],    // Validation pour le nom
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        // Mise à jour des champs séparés
        $user->prenom = $request->prenom;
        $user->nom = $request->nom;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('employe.profil')->with('success', 'Profil mis à jour avec succès !');
    }
}