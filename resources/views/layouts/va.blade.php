<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --background: hsl(210, 40%, 98%);
            --foreground: hsl(222.2, 84%, 4.9%);
            --card: hsl(0, 0%, 100%);
            --card-foreground: hsl(222.2, 84%, 4.9%);
            --primary: hsl(210, 83%, 53%);
            --primary-foreground: hsl(210, 40%, 98%);
            --muted: hsl(210, 40%, 96%);
            --muted-foreground: hsl(215.4, 16.3%, 46.9%);
            --destructive: hsl(0, 84.2%, 60.2%);
            --border: hsl(214.3, 31.8%, 91.4%);
            --success: hsl(142.1, 76.2%, 36.3%);
            --warning: hsl(32.1, 94.6%, 43.3%);
        }
        .text-primary { color: var(--primary); }
        .text-muted-foreground { color: var(--muted-foreground); }
    </style>
    <!-- Alpine.js for interactive components -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</head>

<body class="font-sans antialiased bg-background">
    <div class="min-h-screen bg-gray-100">
        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

        @if (auth()->check())
            {{-- Navigation pour l'Administrateur --}}
            @if (auth()->user()->role == 'admin')
                <nav class="fixed bottom-0 left-0 right-0 bg-card border-t border-border z-40">
                    <div class="flex justify-around items-center h-16 max-w-2xl mx-auto">
                        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'text-primary' : 'text-muted-foreground' }} flex flex-col items-center justify-center p-1 text-center w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mb-1"><path d="M2 12h20M12 2v20"/></svg>
                            <span class="text-xs font-medium">Accueil</span>
                        </a>
                        <a href="{{ route('admin.historique') }}" class="{{ request()->routeIs('admin.historique') ? 'text-primary' : 'text-muted-foreground' }} flex flex-col items-center justify-center p-1 text-center w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mb-1"><path d="M1 4h22v16H1z"/><path d="M9 9h6v6H9z"/></svg>
                            <span class="text-xs font-medium">Historique</span>
                        </a>
                         <a href="{{ route('admin.rapports') }}" class="{{ request()->routeIs('admin.rapports') ? 'text-primary' : 'text-muted-foreground' }} flex flex-col items-center justify-center p-1 text-center w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mb-1"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                            <span class="text-xs font-medium">Rapports</span>
                        </a>
                        <a href="{{ route('admin.conges.index') }}" class="{{ request()->routeIs('admin.conges.index') ? 'text-primary' : 'text-muted-foreground' }} flex flex-col items-center justify-center p-1 text-center w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mb-1"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            <span class="text-xs font-medium">Congés</span>
                        </a>
                         <a href="{{ route('admin.jours-feries.index') }}" class="{{ request()->routeIs('admin.jours-feries.index') ? 'text-primary' : 'text-muted-foreground' }} flex flex-col items-center justify-center p-1 text-center w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mb-1"><path d="M12 22V6M5 12H2a10 10 0 0 0 20 0h-3"/><path d="M5.64 5.64L4.22 4.22"/><path d="M18.36 5.64l1.42-1.42"/></svg>
                            <span class="text-xs font-medium">Fériés</span>
                        </a>
                    </div>
                </nav>
            {{-- Navigation pour l'Employé --}}
            @elseif (auth()->user()->role == 'employe')
                <nav class="fixed bottom-0 left-0 right-0 bg-card border-t border-border z-40">
                    <div class="flex justify-around items-center h-16 max-w-lg mx-auto">
                        <a href="{{ route('employe.dashboard') }}" class="{{ request()->routeIs('employe.dashboard') ? 'text-primary' : 'text-muted-foreground' }} flex flex-col items-center justify-center py-2 px-1 text-center w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mb-1"><path d="M2 12h20M12 2v20"/></svg>
                            <span class="text-xs font-medium">Accueil</span>
                        </a>
                        <a href="{{ route('employe.historique') }}" class="{{ request()->routeIs('employe.historique') ? 'text-primary' : 'text-muted-foreground' }} flex flex-col items-center justify-center py-2 px-1 text-center w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mb-1"><path d="M1 4h22v16H1z"/><path d="M9 9h6v6H9z"/></svg>
                            <span class="text-xs font-medium">Historique</span>
                        </a>
                        <a href="{{ route('employe.conges.index') }}" class="{{ request()->routeIs('employe.conges.index') ? 'text-primary' : 'text-muted-foreground' }} flex flex-col items-center justify-center py-2 px-1 text-center w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mb-1"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            <span class="text-xs font-medium">Congés</span>
                        </a>
                        <a href="{{ route('employe.profil') }}" class="{{ request()->routeIs('employe.profil') ? 'text-primary' : 'text-muted-foreground' }} flex flex-col items-center justify-center py-2 px-1 text-center w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mb-1"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            <span class="text-xs font-medium">Profil</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="flex-grow w-full h-full">
                            @csrf
                            <button type="submit" class="text-muted-foreground flex flex-col items-center justify-center py-2 px-1 w-full h-full">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-1"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                                <span class="text-xs font-medium">Déconnexion</span>
                            </button>
                        </form>
                    </div>
                </nav>
            @endif
        @endif
    </div>
</body>

</html>

