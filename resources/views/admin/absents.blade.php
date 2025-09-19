<x-app-layout>
    <x-slot name="title">
        Employés Absents
    </x-slot>

    <div class="p-4 sm:p-6 lg:p-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Employés Absents du Jour</h1>
            <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline text-sm font-semibold">&larr; Retour au tableau de bord</a>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <div class="space-y-3">
                @forelse($employesAbsents as $employe)
                    <div class="flex items-center justify-between p-3 rounded-lg border">
                        <div class="flex items-center">
                            <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-gray-500 mr-4">
                                <span class="text-sm font-medium leading-none text-white">{{ $employe->getInitials() }}</span>
                            </span>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $employe->prenom }} {{ $employe->nom }}</p>
                                <p class="text-sm text-gray-500">{{ $employe->email }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500 py-4">Aucun employé n'est absent aujourd'hui.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>