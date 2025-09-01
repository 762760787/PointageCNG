<x-app-layout>
    <div class="p-4 sm:p-6 lg:p-8 max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Générateur de codes QR</h1>

        <!-- NOTE: La logique pour créer des emplacements dynamiques n'est pas implémentée. -->
        <!-- Ce formulaire est une maquette visuelle pour correspondre au design. -->
        <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
            <h2 class="text-lg font-semibold mb-4">Créer un nouvel emplacement</h2>
            <form>
                <div class="mb-4">
                    <label for="nom_emplacement" class="block text-sm font-medium text-gray-700 mb-1">Nom de l'emplacement</label>
                    <input type="text" id="nom_emplacement" placeholder="Ex: Entrée principale" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <label for="type_emplacement" class="block text-sm font-medium text-gray-700 mb-1">Type d'emplacement</label>
                    <select id="type_emplacement" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option>Sélectionner le type</option>
                        <option value="ARRIVEE">Arrivée</option>
                        <option value="DEPART">Départ</option>
                        <option value="DEBUT_PAUSE">Début de pause</option>
                        <option value="FIN_PAUSE">Fin de pause</option>
                    </select>
                </div>
                <div>
                    <button type="button" class="bg-blue-600 text-white px-5 py-2.5 rounded-lg font-semibold text-sm hover:bg-blue-700">Créer l'emplacement</button>
                </div>
            </form>
        </div>

        <!-- Liste des QR Codes existants (statiques) -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h2 class="text-lg font-semibold mb-4">Emplacements QR existants</h2>
            <div class="space-y-4">
                @foreach(['ARRIVEE' => 'Heure d\'arrivée', 'DEPART' => 'Heure de départ', 'DEBUT_PAUSE' => 'Début de pause', 'FIN_PAUSE' => 'Fin de pause'] as $code => $label)
                <div class="flex items-center justify-between p-4 bg-white rounded-lg border">
                    <div>
                        <p class="font-semibold text-gray-900">{{ $label }}</p>
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Actif</span>
                    </div>
                    <div>
                        {!! QrCode::size(80)->generate($code) !!}
                    </div>
                </div>
                @endforeach
            </div>
             <div class="mt-6 text-center">
                <button onclick="window.print()" class="bg-gray-600 text-white px-5 py-2.5 rounded-lg font-semibold text-sm hover:bg-gray-700">Imprimer les codes</button>
            </div>
        </div>
    </div>
</x-app-layout>