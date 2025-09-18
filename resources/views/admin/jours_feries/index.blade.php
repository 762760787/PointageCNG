<x-app-layout>
    <x-slot name="title">
        Gestion des Jours Fériés
    </x-slot>

    <div class="p-4 sm:p-6 lg:p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Gestion des Jours Fériés</h1>

        <!-- Formulaire d'ajout -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h2 class="text-lg font-semibold mb-4">Ajouter un jour férié</h2>

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <form action="{{ route('admin.jours-feries.index') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">Nom du jour férié</label>
                        <input type="text" name="nom" id="nom" placeholder="Ex: Fête du Travail" value="{{ old('nom') }}" required class="flex h-10 w-full rounded-md border bg-background px-3 py-2 text-sm">
                        @error('nom') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                        <input type="date" name="date" id="date" value="{{ old('date') }}" required class="flex h-10 w-full rounded-md border bg-background px-3 py-2 text-sm">
                        @error('date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="pt-2">
                    <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2.5 rounded-lg font-semibold hover:bg-blue-700">
                        Enregistrer le jour férié
                    </button>
                </div>
            </form>
        </div>

        <!-- Liste des jours fériés enregistrés -->
        <div class="bg-white rounded-lg border border-gray-200 p-6 mt-8">
            <h2 class="text-lg font-semibold mb-4">Jours fériés de l'année</h2>
            <div class="space-y-3">
                @forelse($joursFeries as $jour)
                    <div class="flex items-center justify-between p-3 rounded-lg border">
                        <div>
                            <p class="font-semibold text-gray-900">{{ $jour->nom }}</p>
                            <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($jour->date)->translatedFormat('l d F Y') }}</p>
                        </div>
                        <form action="{{ route('admin.jours-feries.destroy', $jour) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce jour férié ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-semibold">Supprimer</button>
                        </form>
                    </div>
                @empty
                    <p class="text-center text-gray-500 py-4">Aucun jour férié n'a été enregistré pour le moment.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>

