<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pointage;
use Carbon\Carbon;

class PointageController extends Controller
{
    /**
     * Affiche le tableau de bord principal de l'employé avec toutes les données.
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Récupérer le pointage du jour pour l'accueil
        $pointageDuJour = $user->pointages()->where('date', Carbon::today())->first();

        // Récupérer les 7 derniers pointages pour l'historique
        $pointages = $user->pointages()->latest()->take(7)->get();

        // Envoyer toutes les données à la même vue
        return view('employe.dashboard', compact('pointageDuJour', 'pointages'));
    }


    public function scan(Request $request)
    {
        $request->validate(['scanned_data' => 'required|string|in:ARRIVEE,DEPART']);

        $type = $request->input('scanned_data');
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $pointage = Pointage::firstOrNew([
            'user_id' => $user->id,
            'date' => Carbon::today(),
        ]);

        switch ($type) {
            case 'ARRIVEE':
                if ($pointage->heure_arrivee) {
                    return response()->json(['success' => false, 'message' => 'Une arrivée a déjà été enregistrée.'], 409); // 409 Conflict
                }
                $pointage->heure_arrivee = now();
                break;

            case 'DEPART':
                if (!$pointage->exists || !$pointage->heure_arrivee) {
                    return response()->json(['success' => false, 'message' => 'Vous devez d\'abord pointer votre arrivée.'], 400); // 400 Bad Request
                }
                if ($pointage->heure_depart) {
                    return response()->json(['success' => false, 'message' => 'Un départ a déjà été enregistré.'], 409);
                }
                $pointage->heure_depart = now();
                break;
        }

        $pointage->save();

        // --- MODIFICATION IMPORTANTE ---
        // On ajoute l'URL de redirection à la réponse
        $responseData = [
            'success' => true,
            'message' => 'Pointage enregistré avec succès !',
            'redirect_url' => route('employe.dashboard') // Ajout de la route de redirection
        ];

        return response()->json($responseData);
    }

        /**
         * Enregistre un nouveau pointage via scan QR.
         */
    public function store(Request $request)
    {
            $request->validate(['scan_result' => 'required|string']);

            $scanType = $request->input('scan_result');
            $validTypes = ['ARRIVEE', 'DEPART', 'DEBUT_PAUSE', 'FIN_PAUSE'];

            if (!in_array($scanType, $validTypes)) {
                return response()->json(['success' => false, 'message' => 'QR Code non valide.'], 400);
            }

            /** @var \App\Models\User $user */
            $user = Auth::user();
            $today = Carbon::today();

            // On cherche un pointage existant pour l'utilisateur aujourd'hui ou on en crée un nouveau.
            $pointage = Pointage::firstOrCreate(
                ['user_id' => $user->id, 'date' => $today]
            );

            switch ($scanType) {
                case 'ARRIVEE':
                    if ($pointage->heure_arrivee) {
                        return response()->json(['success' => false, 'message' => 'Une arrivée a déjà été enregistrée aujourd\'hui.'], 409); // 409 Conflict
                    }
                    $pointage->heure_arrivee = now();
                    break;

                case 'DEPART':
                    if (!$pointage->heure_arrivee) {
                        return response()->json(['success' => false, 'message' => 'Vous devez d\'abord enregistrer une arrivée.'], 400);
                    }
                    if ($pointage->heure_depart) {
                        return response()->json(['success' => false, 'message' => 'Un départ a déjà été enregistré.'], 409);
                    }
                    $pointage->heure_depart = now();
                    break;

                // La logique pour les pauses peut être ajoutée ici
                case 'DEBUT_PAUSE':
                    // ...
                    break;

                case 'FIN_PAUSE':
                    // ...
                    break;
            }

            $pointage->save();

            // Préparer la réponse JSON pour le client
            $responseData = [
                'success' => true,
                'message' => 'Pointage enregistré avec succès !',
                'user' => [
                    'nom' => $user->nom,
                    'prenom' => $user->prenom,
                ],
                'pointage' => [
                    'heure_arrivee' => $pointage->heure_arrivee ? Carbon::parse($pointage->heure_arrivee)->format('H:i:s') : null,
                    'heure_depart' => $pointage->heure_depart ? Carbon::parse($pointage->heure_depart)->format('H:i:s') : null,
                ]
            ];

            return response()->json($responseData);
    }

    // '''''''''''''''''''''''''''''''''''''''''''

    // --- CORRECTION APPLIQUÉE ICI ---
    public function scanner()
    {

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // On récupère le pointage du jour, comme pour le tableau de bord.
        // Cela rend la variable $pointageDuJour disponible dans la vue du scanner.
        $pointageDuJour = Pointage::where('user_id', $user->id)
            ->where('date', Carbon::today())
            ->first();

        // On passe la variable à la vue.
        return view('employe.scanner', compact('pointageDuJour'));
    }

    public function historique()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $pointages = $user->pointages()->latest()->take(7)->get();
        return view('employe.historique', compact('pointages'));
    }
}