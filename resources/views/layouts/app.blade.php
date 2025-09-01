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
            --warning: hsl(32.1, 94.6%, 43.7%);
        }

        body {
            font-family: 'Roboto', sans-serif;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .nav-button.active {
            color: var(--primary);
        }
    </style>
</head>
</head>

<body style="background-color: var(--background);">
    <div class="min-h-screen">
        <!-- Page Content -->
        <header class="bg-card border-b border-border sticky top-0 z-40"
            style="background-color: var(--card); border-color: var(--border);">
            <div class="flex items-center justify-between p-4">
                <div class="flex items-center space-x-3">
                    <div class="h-8 w-8 rounded-full flex items-center justify-center"
                        style="background-color: var(--primary);">
                        <a href="{{ route('admin.dashboard')  }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" style="color: var(--primary-foreground);">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                        </svg>
                        </a>
                    </div>
                    <div>
                        <h1 class="font-semibold" style="color: var(--foreground);">Administration</h1>
                        <p class="text-xs" style="color: var(--muted-foreground);">QR Attendance Management</p>
                    </div>
                </div>
            </div>
        </header>
        <main>
            {{ $slot }}
        </main>
        <nav class="fixed bottom-0 left-0 right-0 border-t z-30 lg:hidden" style="background-color: var(--card); border-color: var(--border);">
            <div class="grid grid-cols-3 gap-0">
                <button data-tab="dashboard" class="nav-button active flex flex-col items-center py-2 px-1"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-1"><line x1="18" x2="6" y1="20" y2="20"/><line x1="12" x2="12" y1="20" y2="4"/><line x1="6" x2="18" y1="20" y2="20"/></svg><span class="text-xs font-medium">Tableau de bord</span></button>
                <button data-tab="employees" class="nav-button text-muted-foreground flex flex-col items-center py-2 px-1"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-1"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg><span class="text-xs font-medium">Employés</span></button>
                <button data-tab="qr-generator" class="nav-button text-muted-foreground flex flex-col items-center py-2 px-1"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-1"><rect width="5" height="5" x="3" y="3" rx="1"/><rect width="5" height="5" x="16" y="3" rx="1"/><rect width="5" height="5" x="3" y="16" rx="1"/><path d="M21 16h-3a2 2 0 0 0-2 2v3"/></svg><span class="text-xs font-medium">QR Codes</span></button>
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
</body>

</html>
