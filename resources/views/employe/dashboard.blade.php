<x-app-layout>
    <x-slot name="title">
        Tableau de Bord
    </x-slot>

    <div class="min-h-screen bg-background text-foreground">
        <!-- Header -->
        <header class="bg-card border-b border-border sticky top-0 z-40">
            <div class="flex items-center justify-between p-4">
                <div>
                    {{-- Utilisation de 'name' comme fallback si 'prenom' n'existe pas --}}
                    <h1 class="font-semibold text-lg">Bonjour, {{ Auth::user()->prenom ?? Auth::user()->name }} !</h1>
                    <p class="text-xs text-muted-foreground">{{ Auth::user()->email }}</p>
                </div>
                <div>
                    {{-- --- LOGIQUE DE STATUT CORRIGÉE ET FIABILISÉE --- --}}
                    @if(isset($pointageDuJour) && $pointageDuJour->heure_depart)
                        {{-- Si une heure de départ existe, la journée est terminée --}}
                        <span class="text-xs font-medium bg-gray-100 text-gray-800 px-2.5 py-1 rounded-full">Journée terminée</span>
                    @elseif(isset($pointageDuJour) && $pointageDuJour->heure_arrivee)
                        {{-- Si seule l'heure d'arrivée existe, l'employé est actif --}}
                        <span class="text-xs font-medium bg-green-500/10 text-green-500 px-2.5 py-1 rounded-full">Pointage actif</span>
                    @else
                        {{-- Si aucune heure d'arrivée n'existe pour aujourd'hui, il est hors service --}}
                        <span class="text-xs font-medium bg-yellow-500/10 text-yellow-500 px-2.5 py-1 rounded-full">Hors service</span>
                    @endif
                </div>
            </div>
        </header>

        <!-- Contenu principal -->
        <main id="dashboard" class="p-4 space-y-6 tab-content active pb-20">
            <!-- Cartes des heures de pointage -->
            <div class="grid grid-cols-2 gap-4">
                <div class="rounded-lg border bg-card p-4 text-center">
                    <p class="text-sm text-muted-foreground">Heure d'arrivée</p>
                    <p class="font-bold text-2xl">
                        {{-- Affiche l'heure d'arrivée si elle existe, sinon '--:--' --}}
                        @if(isset($pointageDuJour) && $pointageDuJour->heure_arrivee)
                            {{ \Carbon\Carbon::parse($pointageDuJour->heure_arrivee)->format('H:i') }}
                        @else
                            --:--
                        @endif
                    </p>
                </div>
                <div class="rounded-lg border bg-card p-4 text-center">
                    <p class="text-sm text-muted-foreground">Heure de départ</p>
                    <p class="font-bold text-2xl">
                        {{-- Affiche l'heure de départ si elle existe, sinon '--:--' --}}
                         @if(isset($pointageDuJour) && $pointageDuJour->heure_depart)
                            {{ \Carbon\Carbon::parse($pointageDuJour->heure_depart)->format('H:i') }}
                        @else
                            --:--
                        @endif
                    </p>
                </div>
            </div>

             <!-- Bouton de scan -->
            <div class="text-center">
                 <a href="{{ route('employe.scanner') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-blue-600 text-white hover:bg-blue-700 h-11 px-8 w-full sm:w-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mr-2 h-5 w-5"><path d="M3 7V5a2 2 0 0 1 2-2h2"/><path d="M17 3h2a2 2 0 0 1 2 2v2"/><path d="M21 17v2a2 2 0 0 1-2 2h-2"/><path d="M7 21H5a2 2 0 0 1-2-2v-2"/><rect width="7" height="7" x="8.5" y="8.5" rx="1"/></svg>
                    Scanner un QR Code
                </a>
            </div>


        </main>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const navButtons = document.querySelectorAll('.nav-button');
                const tabContents = document.querySelectorAll('.tab-content');

                navButtons.forEach(button => {
                    // Ne pas attacher l'événement aux boutons de soumission de formulaire
                    if (button.type === 'submit') {
                        return;
                    }

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
    </div>
</x-app-layout>