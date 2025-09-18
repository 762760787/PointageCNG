<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
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
            --accent: hsl(210, 40%, 96%);
            --destructive: hsl(0, 84.2%, 60.2%);
            --border: hsl(214.3, 31.8%, 91.4%);
            --input: hsl(214.3, 31.8%, 91.4%);
            --ring: hsl(210, 83%, 53%);
        }
        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>

<body style="background-color: var(--background);">
    <div class="min-h-screen flex items-center justify-center p-4 bg-gradient-to-br from-primary/10 to-accent/20" style="--tw-gradient-from: hsla(210, 83%, 53%, 0.1); --tw-gradient-to: hsla(210, 40%, 96%, 0.2);">
        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    @stack('scripts')
</body>

</html>
