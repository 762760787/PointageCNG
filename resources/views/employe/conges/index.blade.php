<x-app-layout>
    <x-slot name="title">
        Mes Demandes de Congé
    </x-slot>

    <div class="p-4 sm:p-6 lg:p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Gestion de mes congés</h1>

        <!-- Formulaire de nouvelle demande -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h2 class="text-lg font-semibold mb-4">Faire une nouvelle demande</h2>

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <form action="{{ route('employe.conges.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Type de congé</label>
                    <select name="type" id="type" class="flex h-10 w-full rounded-md border bg-background px-3 py-2 text-sm" required>
                        <option value="Congé Annuel">Congé Annuel</option>
                        <option value="Maladie">Maladie</option>
                        <option value="Congé sans solde">Congé sans solde</option>
                        <option value="Autre">Autre</option>
                    </select>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="date_debut" class="block text-sm font-medium text-gray-700 mb-1">Date de début</label>
                        <input type="date" name="date_debut" id="date_debut" value="{{ old('date_debut') }}" required class="flex h-10 w-full rounded-md border bg-background px-3 py-2 text-sm">
                        @error('date_debut') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="date_fin" class="block text-sm font-medium text-gray-700 mb-1">Date de fin</label>
                        <input type="date" name="date_fin" id="date_fin" value="{{ old('date_fin') }}" required class="flex h-10 w-full rounded-md border bg-background px-3 py-2 text-sm">
                        @error('date_fin') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div>
                    <label for="motif" class="block text-sm font-medium text-gray-700 mb-1">Motif (optionnel)</label>
                    <textarea name="motif" id="motif" rows="3" placeholder="Raison de votre demande..." class="flex min-h-[80px] w-full rounded-md border bg-background px-3 py-2 text-sm">{{ old('motif') }}</textarea>
                </div>
                <div class="pt-2">
                    <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2.5 rounded-lg font-semibold hover:bg-blue-700">
                        Envoyer la demande
                    </button>
                </div>
            </form>
        </div>

        <!-- Historique des demandes -->
        <div class="bg-white rounded-lg border border-gray-200 p-6 mt-8">
            <h2 class="text-lg font-semibold mb-4">Historique de mes demandes</h2>
            <div class="space-y-3">
                @forelse($conges as $conge)
                    <div class="flex items-center justify-between p-3 rounded-lg border">
                        <div>
                            <p class="font-semibold text-gray-900">{{ $conge->type }}</p>
                            <p class="text-sm text-gray-500">Du {{ \Carbon\Carbon::parse($conge->date_debut)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($conge->date_fin)->format('d/m/Y') }}</p>
                        </div>
                        <span class="text-xs font-medium px-2.5 py-1 rounded-full
                            @if($conge->statut == 'Approuvé') bg-green-100 text-green-800
                            @elseif($conge->statut == 'Refusé') bg-red-100 text-red-800
                            @else bg-yellow-100 text-yellow-800 @endif">
                            {{ $conge->statut }}
                        </span>
                    </div>
                @empty
                    <p class="text-center text-gray-500 py-4">Vous n'avez encore fait aucune demande de congé.</p>
                @endforelse
            </div>
        </div>
    </div>
    <nav class="fixed bottom-0 left-0 right-0 bg-card border-t border-border z-40">
        <div class="flex justify-around items-center h-16 max-w-lg mx-auto">
            <a href="{{ route('employe.dashboard') }}" class="{{ request()->routeIs('employe.dashboard') ? 'text-primary' : 'text-muted-foreground' }} flex flex-col items-center justify-center py-2 px-1 text-center w-full">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mb-1"><path d="M2 12h20M12 2v20"/></svg>
                <span class="text-xs font-medium">Accueil</span>
            </a>
            <a href="{{ route('employe.historique') }}" data-tab="historique" class="nav-button text-muted-foreground flex flex-col items-center justify-center py-2 px-1 text-center w-full">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mb-1"><path d="M1 4h22v16H1z"/><path d="M9 9h6v6H9z"/></svg>
                <span class="text-xs font-medium">Historique</span>
            </a>
             {{-- NOUVEAU: Congés --}}
             <a href="{{ route('employe.conges.index') }}" class="{{ request()->routeIs('employe.conges.index') ? 'text-primary' : 'text-muted-foreground' }} flex flex-col items-center justify-center py-2 px-1 text-center w-full">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mb-1"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <span class="text-xs font-medium">Congés</span>
            </a>
            <a href="{{ route('employe.profil') }}" class="{{ request()->routeIs('employe.profil') ? 'text-primary' : 'text-muted-foreground' }} flex flex-col items-center justify-center py-2 px-1 text-center w-full">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mb-1"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <span class="text-xs font-medium">Profil</span>
            </a>
            <!-- BOUTON DE DECONNEXION -->
            <form method="POST" action="{{ route('logout') }}" class="flex-grow w-full">
                @csrf
                <button type="submit" class="nav-button text-muted-foreground flex flex-col items-center justify-center py-2 px-1 w-full h-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-1"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    <span class="text-xs font-medium">Déconnexion</span>
                </button>
            </form>
        </div>
    </nav>
</x-app-layout>
