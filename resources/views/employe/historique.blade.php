<x-app-layout>
    <x-slot name="title">
        Historique des Pointages
    </x-slot>

    <div class="min-h-screen bg-background text-foreground">
        <!-- Header -->
        <header class="bg-card border-b border-border sticky top-0 z-40">
            <div class="flex items-center justify-between p-4">
                <h1 class="font-semibold text-xl">Mon Historique</h1>
            </div>
        </header>

        <!-- Contenu principal -->
        <main class="p-4 pb-20 space-y-4">
            <div class="rounded-lg border bg-card">
                <ul role="list" class="divide-y divide-border">
                    @forelse ($historiquePointages as $pointage)
                        <li class="p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-semibold">{{ \Carbon\Carbon::parse($pointage->date)->translatedFormat('l d F Y') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold text-gray-800">
                                        <span class="text-green-600">{{ $pointage->heure_arrivee ? \Carbon\Carbon::parse($pointage->heure_arrivee)->format('H:i') : '--:--' }}</span>
                                        -
                                        <span class="text-red-600">{{ $pointage->heure_depart ? \Carbon\Carbon::parse($pointage->heure_depart)->format('H:i') : '--:--' }}</span>
                                    </p>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="p-4 text-center text-muted-foreground">
                            Aucun historique de pointage disponible.
                        </li>
                    @endforelse
                </ul>
            </div>
        </main>

        
    </div>
</x-app-layout>
