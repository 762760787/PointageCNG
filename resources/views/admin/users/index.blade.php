   <x-app-layout>
    <div class="p-4 sm:p-6 lg:p-8">
           <h1 class="text-2xl font-bold text-gray-900 mb-6">Gestion des employés</h1>

           <!-- Formulaire d'ajout -->
           <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h2 class="text-lg font-semibold mb-4">Ajouter un employé</h2>
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="prenom" class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                        <input type="text" name="prenom" id="prenom" placeholder="Prénom de l'employé" value="{{ old('prenom') }}" required class="flex h-10 w-full rounded-md border bg-background px-3 py-2 text-sm">
                        @error('prenom') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                        <input type="text" name="nom" id="nom" placeholder="Nom de l'employé" value="{{ old('nom') }}" required class="flex h-10 w-full rounded-md border bg-background px-3 py-2 text-sm">
                        @error('nom') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="mb-6">
                    <label for="identifiant_employe" class="block text-sm font-medium text-gray-700 mb-1">Identifiant employé</label>
                    <input type="text" name="identifiant_employe" id="identifiant_employe" placeholder="Identifiant unique" value="{{ old('identifiant_employe') }}" required class="flex h-10 w-full rounded-md border bg-background px-3 py-2 text-sm">
                    @error('identifiant_employe') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                 <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="email" placeholder="adresse@email.com" value="{{ old('email') }}" required class="flex h-10 w-full rounded-md border bg-background px-3 py-2 text-sm">
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <button type="submit" class="bg-blue-600 text-white px-5 py-2.5 rounded-lg font-semibold text-sm hover:bg-blue-700">Créer l'employé</button>
                </div>
            </form>
        </div>

           <!-- Liste des employés -->
           <div class="bg-white rounded-lg border border-gray-200 p-6 mt-5">
               <h2 class="text-lg font-semibold mb-4">Liste des employés</h2>
               @if (session('success'))
                   <div class="bg-green-100 text-green-800 p-4 rounded mb-4">{{ session('success') }}</div>
               @endif
               <div class="space-y-3">
                   @forelse ($users as $user)
                       <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border">
                           <div class="flex items-center space-x-4">
                               <div
                                   class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold">
                                   {{ strtoupper(substr($user->name, 0, 1)) . strtoupper(substr(explode(' ', $user->name)[1] ?? '', 0, 1)) }}
                               </div>
                               <div>
                                   <p class="font-semibold text-gray-900">{{ $user->name }}</p>
                                   <p class="text-sm text-gray-500">ID: {{ $user->identifiant_employe }}</p>
                               </div>
                           </div>
                           <div class="flex items-center space-x-4">
                               @if ($user->role == 'admin')
                                   <span
                                       class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">admin</span>
                               @else
                                   <span
                                       class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded-full">employe</span>
                               @endif
                               <a href="{{ route('admin.users.edit', $user) }}"
                                   class="text-blue-600 hover:underline text-sm font-semibold">Modifier</a>
                           </div>
                       </div>
                   @empty
                       <p class="text-center text-gray-500 py-4">Aucun employé trouvé.</p>
                   @endforelse
               </div>
           </div>
       </div>
   </x-app-layout>
