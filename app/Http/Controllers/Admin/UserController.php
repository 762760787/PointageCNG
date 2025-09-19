<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules; // Important: Importer la classe des règles

class UserController extends Controller
{
    /**
     * Affiche la liste des utilisateurs.
     */
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Enregistre un nouvel utilisateur dans la base de données.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'prenom' => ['required', 'string', 'max:255'],
            'nom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'identifiant_employe' => ['required', 'string', 'max:255', 'unique:users'],
        ]);

        User::create([
            'prenom' => $validatedData['prenom'],
            'nom' => $validatedData['nom'],
            'email' => $validatedData['email'],
            'identifiant_employe' => $validatedData['identifiant_employe'],
            'password' => Hash::make('NG2025'), // Mot de passe par défaut
            'role' => 'employe',
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Employé créé avec succès.');
    }


    /**
     * Affiche le formulaire de modification d'un utilisateur.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Met à jour un utilisateur dans la base de données.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'prenom' => ['required', 'string', 'max:255'],
            'nom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'identifiant_employe' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', 'string', Rule::in(['admin', 'employe'])],
            // Le mot de passe est optionnel, mais s'il est fourni, il doit être confirmé
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        // Prépare les données à mettre à jour
        $updateData = $request->only(['prenom', 'nom', 'email', 'identifiant_employe', 'role']);

        // Vérifie si un nouveau mot de passe a été entré
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return redirect()->route('admin.users.index')->with('success', 'Employé mis à jour avec succès.');
    }

    /**
     * Supprime un utilisateur.
     */
    public function destroy(User $user)
    {
        // On ne peut pas supprimer le premier admin
        if ($user->id === 1) {
            return back()->with('error', 'Vous ne pouvez pas supprimer l\'administrateur principal.');
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Employé supprimé avec succès.');
    }
}
