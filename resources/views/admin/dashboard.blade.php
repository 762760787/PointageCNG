<x-app-layout>
    <x-slot name="title">
        Administration
    </x-slot>

    <!-- Header -->
    <div class="p-4 sm:p-6 lg:p-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
        <div class="flex items-center justify-between p-4">
            <div>
                <h1 class="font-semibold text-xl">Tableau de bord Admin</h1>
            </div>
        </div>
    </div>

    <main class="p-4 space-y-6">
        <!-- Contenu de l'onglet Tableau de bord -->
        <div id="dashboard" class="tab-content active p-4 pb-20 space-y-6">
            <!-- 1. Cartes de statistiques dynamiques -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="rounded-lg border bg-card"><div class="p-4 flex items-center justify-between"><div><p class="text-sm text-muted-foreground">Présents</p><p class="text-2xl font-bold" style="color: var(--success);">{{ $presents }}</p></div><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--success);"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div></div>
                <div class="rounded-lg border bg-card"><div class="p-4 flex items-center justify-between"><div><p class="text-sm text-muted-foreground">En retard</p><p class="text-2xl font-bold" style="color: var(--warning);">{{ $enRetard }}</p></div><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--warning);"><circle cx="12" cy="12" r="10"/><line x1="12" y1="6" x2="12" y2="12"/><line x1="12" y1="12" x2="16" y2="14"/></svg></div></div>
                <div class="rounded-lg border bg-card"><div class="p-4 flex items-center justify-between"><div><p class="text-sm text-muted-foreground">Absents</p><p class="text-2xl font-bold" style="color: var(--destructive);">{{ $absents }}</p></div><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--destructive);"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg></div></div>
                <div class="rounded-lg border bg-card"><div class="p-4 flex items-center justify-between"><div><p class="text-sm text-muted-foreground">Total</p><p class="text-2xl font-bold">{{ $totalEmployes }}</p></div><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div></div>
            </div>

            <!-- 2. Présence en temps réel -->
            <div class="rounded-lg border bg-card">
                <div class="p-4"><h3 class="font-semibold">Présence en temps réel</h3></div>
                <div class="p-4 pt-0">
                    <ul role="list" class="divide-y divide-border">
                        @php
                            $realtimePresence = $pointagesDuJour->whereNull('heure_depart');
                        @endphp
                        @forelse ($realtimePresence as $pointage)
                            <li class="py-3 sm:py-4 flex items-center space-x-4">
                                <div class="flex-shrink-0"><span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-gray-500"><span class="text-xs font-medium leading-none text-white">{{ optional($pointage->user)->getInitials() }}</span></span></div>
                                <div class="flex-1 min-w-0"><p class="text-sm font-medium text-foreground truncate">{{ optional($pointage->user)->name }}</p></div>
                                <div class="inline-flex items-center text-sm font-semibold text-foreground">Arrivé à {{ \Carbon\Carbon::parse($pointage->heure_arrivee)->format('H:i') }}</div>
                            </li>
                        @empty
                            <li class="py-4 text-center text-muted-foreground">Personne n'est actuellement sur site.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- Actions rapides -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h2 class="text-lg font-semibold mb-4">Actions rapides</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('admin.qrcodes.create') }}" class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-lg border hover:bg-gray-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-blue-600 mb-2"><rect width="5" height="5" x="3" y="3" rx="1"/><rect width="5" height="5" x="16" y="3" rx="1"/><rect width="5" height="5" x="3" y="16" rx="1"/><path d="M21 16h-3a2 2 0 0 0-2 2v3"/></svg>
                    <span class="font-semibold text-sm text-blue-600">Générer QR</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-lg border hover:bg-gray-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-gray-600 mb-2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/></svg>
                    <span class="font-semibold text-sm text-gray-600">Employés</span>
                </a>
                <a href="{{ route('admin.rapports') }}" class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-lg border hover:bg-gray-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-gray-600 mb-2"><path d="M3 3v18h18"/></svg>
                    <span class="font-semibold text-sm text-gray-600">Rapports</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-lg border hover:bg-gray-100 transition-colors w-full h-full">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-gray-600 mb-2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                        <span class="font-semibold text-sm text-gray-600">Déconnexion</span>
                    </a>
                </form>
            </div>
        </div>


            <!-- 4. Pointages du jour (Liste complète) -->
            <div class="rounded-lg border bg-card">
                <div class="p-4"><h3 class="font-semibold">Pointages du jour</h3></div>
                <div class="p-4 pt-0">
                    <ul role="list" class="divide-y divide-border">
                        @forelse ($pointagesDuJour as $pointage)
                            <li class="py-3 sm:py-4"><div class="flex items-center space-x-4"><div class="flex-shrink-0"><span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-gray-500"><span class="text-xs font-medium leading-none text-white">{{ optional($pointage->user)->getInitials() }}</span></span></div><div class="flex-1 min-w-0"><p class="text-sm font-medium text-foreground truncate">{{ optional($pointage->user)->name }}</p><p class="text-sm text-muted-foreground truncate">{{ optional($pointage->user)->email }}</p></div><div class="inline-flex flex-col items-end text-base font-semibold text-foreground"><span class="text-sm font-bold">{{ \Carbon\Carbon::parse($pointage->heure_arrivee)->format('H:i') }}</span>@if($pointage->heure_depart)<span class="text-xs font-medium text-muted-foreground">{{ \Carbon\Carbon::parse($pointage->heure_depart)->format('H:i') }}</span>@else<span class="text-xs font-medium bg-success/10 text-success px-2 py-0.5 rounded-full">Présent</span>@endif</div></div></li>
                        @empty
                            <li class="py-4 text-center text-muted-foreground">Aucun pointage pour aujourd'hui.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        </main>

    
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
