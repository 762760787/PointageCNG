<x-app-layout>
    <x-slot name="title">
        Gérer les QR Codes
    </x-slot>

    <div class="p-4 sm:p-6 lg:p-8 max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Générateur de codes QR</h1>

        <!-- Formulaire de création -->
        <div class="bg-white rounded-lg border border-gray-200 p-6 mb-8">
            <h2 class="text-lg font-semibold mb-4">Créer un nouvel emplacement</h2>

            <!-- Message de succès -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <form action="{{ route('admin.qrcodes.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="nom_emplacement" class="block text-sm font-medium text-gray-700 mb-1">Nom de l'emplacement</label>
                    <input type="text" name="nom_emplacement" id="nom_emplacement" placeholder="Ex: Entrée principale"
                           value="{{ old('nom_emplacement') }}" required
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('nom_emplacement') border-red-500 @enderror">
                     @error('nom_emplacement')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="mb-6">
                    <label for="type_emplacement" class="block text-sm font-medium text-gray-700 mb-1">Type d'emplacement</label>
                    <select name="type_emplacement" id="type_emplacement" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="ARRIVEE">Arrivée</option>
                        <option value="DEPART">Départ</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="w-full bg-blue-600 text-white px-5 py-2.5 rounded-lg font-semibold text-sm hover:bg-blue-700">
                        Générer et Enregistrer
                    </button>
                </div>
            </form>
        </div>

        <!-- Section pour afficher les QR Codes existants -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h2 class="text-lg font-semibold mb-4">QR Codes Existants</h2>
            @if($qrcodes->isEmpty())
                <p class="text-center text-gray-500">Aucun QR Code n'a été généré pour le moment.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($qrcodes as $qrcode)
                        <div class="border rounded-lg p-4 flex flex-col items-center text-center">
                            <div class="p-2 border rounded-lg mb-3">
                                {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(150)->generate($qrcode->value) !!}
                            </div>
                            <h3 class="font-semibold text-gray-800">{{ $qrcode->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $qrcode->type }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>