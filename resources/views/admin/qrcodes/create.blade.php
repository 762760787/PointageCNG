<x-app-layout>
    <x-slot name="title">
        Générer un QR Code
    </x-slot>

    <div class="p-4 sm:p-6 lg:p-8 max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Générateur de codes QR</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Formulaire de création -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h2 class="text-lg font-semibold mb-4">Créer un nouvel emplacement</h2>
                <form action="{{ route('admin.qrcodes.generate') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="nom_emplacement" class="block text-sm font-medium text-gray-700 mb-1">Nom de l'emplacement</label>
                        <input type="text" name="nom_emplacement" id="nom_emplacement" placeholder="Ex: Entrée principale"
                               value="{{ $locationName ?? old('nom_emplacement') }}" required
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div class="mb-6">
                        <label for="type_emplacement" class="block text-sm font-medium text-gray-700 mb-1">Type d'emplacement</label>
                        <select name="type_emplacement" id="type_emplacement" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Sélectionner le type</option>
                            <option value="ARRIVEE" @selected(isset($qrData) && $qrData == 'ARRIVEE')>Arrivée</option>
                            <option value="DEPART" @selected(isset($qrData) && $qrData == 'DEPART')>Départ</option>
                            <option value="DEBUT_PAUSE" @selected(isset($qrData) && $qrData == 'DEBUT_PAUSE')>Début de pause</option>
                            <option value="FIN_PAUSE" @selected(isset($qrData) && $qrData == 'FIN_PAUSE')>Fin de pause</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="bg-blue-600 text-white px-5 py-2.5 rounded-lg font-semibold text-sm w-full hover:bg-blue-700">Générer le QR Code</button>
                    </div>
                </form>
            </div>

            <!-- Affichage du QR Code généré -->
            <div class="bg-white rounded-lg border border-gray-200 p-6 flex flex-col items-center justify-center">
                @if (isset($qrData))
                    <h2 class="text-lg font-semibold mb-2">{{ $locationName }}</h2>
                    <p class="text-sm text-gray-500 mb-4">Type: {{ $qrData }}</p>
                    <div class="p-2 border rounded-lg">
                        {{-- Correction: Utiliser le namespace complet pour éviter l'erreur de syntaxe --}}
                        {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(220)->generate($qrData) !!}
                    </div>
                    <button onclick="window.print()" class="mt-6 bg-gray-600 text-white px-5 py-2.5 rounded-lg font-semibold text-sm hover:bg-gray-700">
                        Imprimer
                    </button>
                @else
                    <div class="text-center text-gray-500">
                        <svg xmlns="[http://www.w3.org/2000/svg](http://www.w3.org/2000/svg)" class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4v16m8-8H4" /></svg>
                        <p class="mt-2">Le QR code apparaîtra ici une fois généré.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>