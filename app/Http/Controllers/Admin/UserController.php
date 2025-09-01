<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller {
    public function index() {
        $users = User::latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function create() {
        return view('admin.users.index');
    }

    public function store(Request $request) {
        $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'identifiant_employe' => 'required|string|max:255|unique:users',
        ]);
        $password = Str::random(10);
        User::create([
            'prenom' => $request->prenom,
            'nom' => $request->nom,
            'email' => $request->email,
            'identifiant_employe' => $request->identifiant_employe,
            'password' => Hash::make($password),
        ]);
        return redirect()->route('admin.users.index')->with('success', 'Employé créé avec succès. Mot de passe temporaire : ' . $password);
    }

    public function edit(User $user) {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user) {
        $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'identifiant_employe' => 'required|string|max:255|unique:users,identifiant_employe,' . $user->id,
            'role' => 'required|string|in:admin,employe',
        ]);

        $user->update($request->all());
        return redirect()->route('admin.users.index')->with('success', 'Informations de l\'employé mises à jour.');
    }

    public function destroy(User $user) {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Employé supprimé.');
    }
}