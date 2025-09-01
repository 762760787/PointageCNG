{{-- <x-app-layout>
    <x-slot name="title">
        Administration
    </x-slot>

    <!-- Header -->
    <header class="bg-card border-b border-border sticky top-0 z-40">
        <div class="flex items-center justify-between p-4">
            <h1 class="font-semibold text-xl">Tableau de bord Admin</h1>
            <!-- Menu de navigation admin ici -->
        </div>
    </header>

    <main class="p-4 space-y-6">
        <!-- Cartes de statistiques -->
        <div id="dashboard" class="tab-content active p-4 pb-20 space-y-6">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="rounded-lg border bg-card"><div class="p-4 flex items-center justify-between"><div><p class="text-sm text-muted-foreground">Présents</p><p class="text-2xl font-bold" style="color: var(--success);">15</p></div><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--success);"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><polyline points="16 11 18 13 22 9"/></svg></div></div>
                <div class="rounded-lg border bg-card"><div class="p-4 flex items-center justify-between"><div><p class="text-sm text-muted-foreground">En retard</p><p class="text-2xl font-bold" style="color: var(--warning);">2</p></div><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--warning);"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div></div>
                <div class="rounded-lg border bg-card"><div class="p-4 flex items-center justify-between"><div><p class="text-sm text-muted-foreground">Absents</p><p class="text-2xl font-bold" style="color: var(--destructive);">3</p></div><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--destructive);"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="15" x2="23" y1="15" y2="23"/><line x1="23" x2="15" y1="15" y2="23"/></svg></div></div>
                <div class="rounded-lg border bg-card"><div class="p-4 flex items-center justify-between"><div><p class="text-sm text-muted-foreground">Total</p><p class="text-2xl font-bold" style="color: var(--primary);">18</p></div><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--primary);"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div></div>
            </div>

            <!-- Actions rapides -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h2 class="text-lg font-semibold mb-4">Actions rapides</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('qrcodescreate') }}" class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-lg border hover:bg-gray-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-blue-600 mb-2"><rect width="5" height="5" x="3" y="3" rx="1"/><rect width="5" height="5" x="16" y="3" rx="1"/><rect width="5" height="5" x="3" y="16" rx="1"/><path d="M21 16h-3a2 2 0 0 0-2 2v3"/></svg>
                    <span class="font-semibold text-sm text-blue-600">Générer QR</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-lg border hover:bg-gray-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-gray-600 mb-2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/></svg>
                    <span class="font-semibold text-sm text-gray-600">Employés</span>
                </a>
                <a href="#" class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-lg border hover:bg-gray-100 transition-colors">
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

            <div class="rounded-lg border bg-card"><div class="p-6"><h3 class="text-lg font-semibold mb-4">Présence en temps réel</h3><div class="space-y-3"><div class="flex items-center justify-between p-3 rounded-lg" style="background-color: var(--muted);"><div class="flex items-center space-x-3"><div class="w-10 h-10 rounded-full flex items-center justify-center" style="background-color: var(--primary);"><span class="text-sm font-medium text-primary-foreground">JD</span></div><div><p class="font-medium">Jean Dupont</p><p class="text-xs text-muted-foreground">EMP123</p></div></div><div class="text-right"><span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold" style="background-color: hsla(142.1, 76.2%, 36.3%, 0.1); color: hsl(142.1, 76.2%, 26.3%);">Présent</span><p class="text-xs text-muted-foreground mt-1">09:01</p></div></div></div></div></div>
        </div>



        <!-- QR Generator Tab -->
        <div id="qr-generator" class="tab-content p-4 pb-20 space-y-6">
            <h2 class="text-xl font-semibold">Générateur de codes QR</h2>
            <div class="rounded-lg border bg-card"><div class="p-6"><h3 class="text-lg font-semibold mb-4">Emplacements QR existants</h3><div class="space-y-4"><div class="flex items-center justify-between p-4 border rounded-lg"><div class="flex-1"><h4 class="font-medium">Entrée Principale</h4><p class="text-sm text-muted-foreground">ARRIVEE</p></div><div class="w-32 h-32 bg-muted border rounded-lg flex items-center justify-center"><p class="text-xs text-muted-foreground">QR Code ici</p></div></div></div></div></div>
        </div>

        <!-- Tableau des pointages du jour -->
        <div class="rounded-lg border bg-card p-4">
            <h2 class="font-semibold mb-4">Pointages du jour</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs uppercase bg-muted">
                        <tr>
                            <th class="px-6 py-3">Employé</th>
                            <th class="px-6 py-3">Arrivée</th>
                            <th class="px-6 py-3">Départ</th>
                            <th class="px-6 py-3">Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pointagesDuJour as $pointage)
                        <tr class="bg-card border-b">
                            <td class="px-6 py-4 font-medium">{{ $pointage->user->name }}</td>
                            <td class="px-6 py-4">{{ $pointage->heure_arrivee?->format('H:i:s') ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $pointage->heure_depart?->format('H:i:s') ?? 'N/A' }}</td>
                            <td class="px-6 py-4">
                                @if($pointage->heure_depart)
                                    <span class="text-red-500">Parti</span>
                                @elseif($pointage->heure_arrivee)
                                    <span class="text-green-500">Présent</span>
                                @else
                                    <span class="text-gray-500">Absent</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">Aucun pointage aujourd'hui.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
     <!-- Bottom Navigation for Mobile -->

</x-app-layout> --}}