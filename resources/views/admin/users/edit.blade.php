<x-app-layout>
    <div class="p-4 sm:p-6 lg:p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Modifier l'employé</h1>
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h2 class="text-lg font-semibold mb-4">{{ $user->name }}</h2>
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="prenom" class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                        <input type="text" name="prenom" id="prenom" value="{{ old('prenom', $user->prenom) }}" required class="w-full h-10 px-3 py-2 text-sm bg-background border border-input rounded-md focus:outline-none focus:ring-2 focus:ring-ring">
                    </div>
                    <div>
                        <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                        <input type="text" name="nom" id="nom" value="{{ old('nom', $user->nom) }}" required class="w-full h-10 px-3 py-2 text-sm bg-background border border-input rounded-md focus:outline-none focus:ring-2 focus:ring-ring">
                    </div>
                </div>
                <div class="mb-6">
                    <label for="identifiant_employe" class="block text-sm font-medium text-gray-700 mb-1">Identifiant employé</label>
                    <input type="text" name="identifiant_employe" id="identifiant_employe" value="{{ old('identifiant_employe', $user->identifiant_employe) }}" required class="w-full h-10 px-3 py-2 text-sm bg-background border border-input rounded-md focus:outline-none focus:ring-2 focus:ring-ring">
                </div>
                 <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required class="w-full h-10 px-3 py-2 text-sm bg-background border border-input rounded-md focus:outline-none focus:ring-2 focus:ring-ring">
                </div>
                <div class="mb-6">
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Rôle</label>
                    <select name="role" id="role" class="w-full h-10 px-3 py-2 text-sm bg-background border border-input rounded-md focus:outline-none focus:ring-2 focus:ring-ring">
                        <option value="employe" @selected(old('role', $user->role) == 'employe')>Employé</option>
                        <option value="admin" @selected(old('role', $user->role) == 'admin')>Administrateur</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="bg-blue-600 text-white px-5 py-2.5 rounded-lg font-semibold text-sm hover:bg-blue-700">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
