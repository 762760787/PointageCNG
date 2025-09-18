<?php

namespace App\Http\Controllers\Admin;
use App\Models\Qrcode;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QrCodeController extends Controller
{
    /**
     * Affiche le formulaire de création et la liste des QR Codes existants.
     */
    public function create()
    {
        // Cette ligne fonctionnera maintenant car le contrôleur sait où trouver "Qrcode"
        $qrcodes = Qrcode::latest()->get();
        return view('admin.qrcodes.create', compact('qrcodes'));
    }

    /**
     * Enregistre un nouveau QR Code dans la base de données.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom_emplacement' => 'required|string|max:255|unique:qrcodes,name',
            'type_emplacement' => 'required|in:ARRIVEE,DEPART',
        ]);

        // Cette ligne fonctionnera aussi
        Qrcode::create([
            'name' => $request->input('nom_emplacement'),
            'type' => $request->input('type_emplacement'),
            'value' => $request->input('type_emplacement'),
        ]);

        return redirect()->route('admin.qrcodes.create')->with('success', 'QR Code généré et enregistré avec succès !');
    }
}
