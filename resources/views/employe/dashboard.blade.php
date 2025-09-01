<x-app-layout>
    <x-slot name="title">
        Tableau de Bord
    </x-slot>

    <style>
        /* Styles pour la navigation par onglets */
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        .nav-button.active { color: hsl(var(--primary)); }
    </style>

    <div class="min-h-screen bg-background text-foreground">
        <!-- Header -->
        <header class="bg-card border-b border-border sticky top-0 z-40">
            <div class="flex items-center justify-between p-4">
                <div>
                    <h1 class="font-semibold text-lg">Bonjour, {{ Auth::user()->prenom }} !</h1>
                    <p class="text-xs text-muted-foreground">{{ Auth::user()->email }}</p>
                </div>
                <div>
                    @if($pointageDuJour && $pointageDuJour->heure_depart)
                        <span class="text-xs font-medium bg-gray-100 text-gray-800 px-2.5 py-1 rounded-full">Journée terminée</span>
                    @elseif($pointageDuJour && $pointageDuJour->heure_arrivee)
                        <span class="text-xs font-medium bg-success/10 text-success px-2.5 py-1 rounded-full">Pointage actif</span>
                    @else
                        <span class="text-xs font-medium bg-warning/10 text-warning px-2.5 py-1 rounded-full">Hors service</span>
                    @endif
                </div>
            </div>
        </header>

        <!-- Contenu principal -->
        <main class="p-4 pb-24">
            <!-- Onglet Accueil -->
            <div id="accueil" class="tab-content active space-y-6">
                <!-- Résumé du jour -->
                <div class="bg-card rounded-lg border p-4">
                    <h2 class="font-semibold mb-3">Résumé du jour</h2>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div class="space-y-1">
                            <p class="text-muted-foreground">Heure d'arrivée</p>
                            <p class="font-semibold text-success">{{ $pointageDuJour?->heure_arrivee ? \Carbon\Carbon::parse($pointageDuJour->heure_arrivee)->format('H:i') : '--:--' }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-muted-foreground">Heure de départ</p>
                            <p class="font-semibold text-destructive">{{ $pointageDuJour?->heure_depart ? \Carbon\Carbon::parse($pointageDuJour->heure_depart)->format('H:i') : '--:--' }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-muted-foreground">Début de pause</p>
                            <p class="font-semibold">{{ ($pointageDuJour && $pointageDuJour->pauses && end($pointageDuJour->pauses)['debut']) ? \Carbon\Carbon::parse(end($pointageDuJour->pauses)['debut'])->format('H:i') : '--:--' }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-muted-foreground">Fin de pause</p>
                            <p class="font-semibold">{{ ($pointageDuJour && $pointageDuJour->pauses && end($pointageDuJour->pauses)['fin']) ? \Carbon\Carbon::parse(end($pointageDuJour->pauses)['fin'])->format('H:i') : '--:--' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Action Rapide -->
                <div class="bg-card rounded-lg border p-4 text-center">
                     <h2 class="font-semibold mb-3">Action Rapide</h2>
                     <a href="{{ route('employe.scanner') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium h-12 px-8 w-full bg-primary text-primary-foreground hover:bg-primary/90">
                        <svg xmlns="[http://www.w3.org/2000/svg](http://www.w3.org/2000/svg)" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mr-2"><path d="M3 7V5a2 2 0 0 1 2-2h2"/><path d="M17 3h2a2 2 0 0 1 2 2v2"/><path d="M21 17v2a2 2 0 0 1-2 2h-2"/><path d="M7 21H5a2 2 0 0 1-2-2v-2"/><rect width="7" height="7" x="8.5" y="8.5" rx="1"/></svg>
                        Scanner un QR Code
                    </a>
                </div>
            </div>

             <!-- Onglet Historique -->
            <div id="historique" class="tab-content space-y-3">
                 <h2 class="text-lg font-semibold text-foreground mb-3">Votre historique récent</h2>
                @forelse ($pointages as $pointage)
                    <div class="bg-card rounded-lg border p-4 flex justify-between items-center">
                        <div>
                            <p class="font-semibold">{{ \Carbon\Carbon::parse($pointage->date)->translatedFormat('l j F Y') }}</p>
                            <p class="text-sm text-muted-foreground">
                                Arrivée: {{ $pointage->heure_arrivee ? \Carbon\Carbon::parse($pointage->heure_arrivee)->format('H:i') : 'N/A' }}
                                - Départ: {{ $pointage->heure_depart ? \Carbon\Carbon::parse($pointage->heure_depart)->format('H:i') : 'N/A' }}
                            </p>
                        </div>
                        <div class="text-right">
                           @if($pointage->heure_depart)
                                <span class="text-xs font-medium bg-gray-100 text-gray-800 px-2.5 py-1 rounded-full">Terminé</span>
                           @else
                                <span class="text-xs font-medium bg-success/10 text-success px-2.5 py-1 rounded-full">En cours</span>
                           @endif
                        </div>
                    </div>
                @empty
                    <div class="bg-card rounded-lg border p-6 text-center">
                        <p class="text-muted-foreground">Aucun historique de pointage trouvé.</p>
                    </div>
                @endforelse
            </div>

            <!-- Onglet Profil -->
            <div id="profil" class="tab-content space-y-4">
                 <h2 class="text-lg font-semibold text-foreground mb-3">Votre profil</h2>
                <div class="bg-card rounded-lg border p-4">
                    <p class="text-sm text-muted-foreground">Nom complet</p>
                    <p class="font-medium">{{ Auth::user()->name }}</p>
                </div>
                <div class="bg-card rounded-lg border p-4">
                    <p class="text-sm text-muted-foreground">Identifiant Employé</p>
                    <p class="font-medium">{{ Auth::user()->identifiant_employe }}</p>
                </div>
                <div class="bg-card rounded-lg border p-4">
                    <p class="text-sm text-muted-foreground">Email</p>
                    <p class="font-medium">{{ Auth::user()->email }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-6">
                    @csrf
                    <button type="submit" class="w-full text-center py-3 rounded-lg text-sm font-medium bg-destructive/10 text-destructive">
                        Se déconnecter
                    </button>
                </form>
            </div>
        </main>

        <!-- Menu de navigation en bas -->
        <nav class="fixed bottom-0 left-0 right-0 bg-card border-t border-border">
            <div class="flex justify-around">
                <button data-tab="accueil" class="nav-button active flex flex-col items-center py-3 px-2 w-full">
                    <svg xmlns="[http://www.w3.org/2000/svg](http://www.w3.org/2000/svg)" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    <span class="text-xs font-medium">Accueil</span>
                </button>
                <button data-tab="historique" class="nav-button text-muted-foreground flex flex-col items-center py-3 px-2 w-full">
                    <svg xmlns="[http://www.w3.org/2000/svg](http://www.w3.org/2000/svg)" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
                    <span class="text-xs font-medium">Historique</span>
                </button>
                <button data-tab="profil" class="nav-button text-muted-foreground flex flex-col items-center py-3 px-2 w-full">
                    <svg xmlns="[http://www.w3.org/2000/svg](http://www.w3.org/2000/svg)" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <span class="text-xs font-medium">Profil</span>
                </button>
            </div>
        </nav>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const navButtons = document.querySelectorAll('.nav-button');
            const tabContents = document.querySelectorAll('.tab-content');

            navButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const tabId = button.getAttribute('data-tab');

                    navButtons.forEach(btn => {
                        btn.classList.remove('active');
                        btn.classList.add('text-muted-foreground');
                    });
                    button.classList.add('active');
                    button.classList.remove('text-muted-foreground');

                    tabContents.forEach(content => {
                        if (content.id === tabId) {
                            content.classList.add('active');
                        } else {
                            content.classList.remove('active');
                        }
                    });
                });
            });
        });
    </script>
</x-app-layout>