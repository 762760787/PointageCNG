<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QrCodeController extends Controller
{
    /**
     * Affiche le formulaire de création de QR Code.
     */
    public function create()
    {
        return view('admin.qrcodes.create');
    }

    /**
     * Génère un QR Code basé sur les données du formulaire.
     */
    public function generate(Request $request)
    {
        $request->validate([
            'nom_emplacement' => 'required|string|max:255',
            'type_emplacement' => 'required|in:ARRIVEE,DEPART,DEBUT_PAUSE,FIN_PAUSE',
        ]);

        $dataToEncode = $request->input('type_emplacement');
        $locationName = $request->input('nom_emplacement');

        // On retourne à la même vue avec les données nécessaires pour afficher le QR code
        return view('admin.qrcodes.create', [
            'qrData' => $dataToEncode,
            'locationName' => $locationName
        ]);
    }
}
