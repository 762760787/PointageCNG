
<x-guest-layout>
    <div class="w-full max-w-md space-x-6" style="align-content: center;" >
        <div class="text-center">
            <div class="mx-auto h-16 w-16 rounded-full flex items-center justify-center mb-4" style="background-color: var(--primary);">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--primary-foreground);">
                    <rect width="5" height="5" x="3" y="3" rx="1"/><rect width="5" height="5" x="16" y="3" rx="1"/><rect width="5" height="5" x="3" y="16" rx="1"/><path d="M21 16h-3a2 2 0 0 0-2 2v3"/><path d="M21 21v.01"/><path d="M12 7v3a2 2 0 0 1-2 2H7"/><path d="M3 12h.01"/><path d="M12 3h.01"/><path d="M12 16v.01"/><path d="M16 12h.01"/><path d="M21 12h.01"/><path d="M12 21h.01"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold" style="color: var(--foreground);">SEN Pointage</h1>
            <p class="mt-2" style="color: var(--muted-foreground);">Solution moderne de suivi du temps</p>
        </div>

        <div class="rounded-lg border bg-card text-card-foreground shadow-sm " style="background-color: var(--card); color: var(--card-foreground); border-color: var(--border); ">
            <div class="p-6">
                 <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium mb-2" style="color: var(--foreground);">
                            Email ou Identifiant employé
                        </label>
                        <input id="email" name="email" type="text" placeholder="Votre email ou identifiant" value="{{ old('email') }}" required autofocus class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background" style="border-color: var(--input); background-color: var(--background);"/>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium mb-2" style="color: var(--foreground);">
                            Mot de passe
                        </label>
                        <input id="password" name="password" type="password" placeholder="••••••••" required class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background" style="border-color: var(--input); background-color: var(--background);"/>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <button type="submit" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors h-10 px-4 py-2 w-full" style="background-color: var(--primary); color: var(--primary-foreground);">
                        Se connecter
                    </button>
                </form>

                @if (Route::has('password.request'))
                <div class="mt-4 text-center">
                    <a href="{{ route('password.request') }}" class="text-sm text-muted-foreground hover:text-primary">
                        Mot de passe oublié ?
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-guest-layout>