<x-app-layout>
    <x-slot name="title">
        Planification des Congés
    </x-slot>

    <div class="p-4 sm:p-6 lg:p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Planification et Calendrier des Congés</h1>

        <!-- Formulaire de planification -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h2 class="text-lg font-semibold mb-4">Planifier un congé pour un employé</h2>
             <form action="{{ route('admin.conges.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Employé</label>
                    <select name="user_id" id="user_id" class="flex h-10 w-full rounded-md border bg-background px-3 py-2 text-sm" required>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->prenom }} {{ $employee->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="type">Type de congé</label>
                        <select name="type" id="type" class="flex h-10 w-full rounded-md border bg-background px-3 py-2 text-sm" required>
                            <option value="Congé Annuel">Congé Annuel</option>
                            <option value="Maladie">Maladie</option>
                            <option value="Congé sans solde">Congé sans solde</option>
                        </select>
                    </div>
                     <div>
                        <label for="statut">Statut</label>
                        <select name="statut" id="statut" class="flex h-10 w-full rounded-md border bg-background px-3 py-2 text-sm" required>
                            <option value="Approuvé">Approuvé</option>
                            <option value="En attente">En attente</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="date_debut">Date de début</label>
                        <input type="date" name="date_debut" id="date_debut" required class="flex h-10 w-full rounded-md border bg-background px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label for="date_fin">Date de fin</label>
                        <input type="date" name="date_fin" id="date_fin" required class="flex h-10 w-full rounded-md border bg-background px-3 py-2 text-sm">
                    </div>
                </div>
                <div class="pt-2">
                    <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2.5 rounded-lg font-semibold hover:bg-blue-700">Enregistrer le congé</button>
                </div>
            </form>
        </div>

        <!-- Liste des employés en congé par mois -->
        <div class="bg-white rounded-lg border border-gray-200 p-6 mt-8">
            <h2 class="text-lg font-semibold mb-4">Employés en congé (Année {{ $year }})</h2>
            <div class="space-y-4">
                 @forelse($congesByMonth as $month => $congesOfMonth)
                    <div x-data="{ open: false }" class="border rounded-lg">
                        <div @click="open = !open" class="p-3 cursor-pointer bg-gray-50 flex justify-between items-center">
                            <h3 class="font-semibold">{{ $month }}</h3>
                            <span class="text-sm bg-blue-100 text-blue-800 px-2 rounded-full">{{ $congesOfMonth->count() }} congé(s)</span>
                        </div>
                        <div x-show="open" class="p-3 space-y-2">
                            @foreach($congesOfMonth as $conge)
                                <div class="flex justify-between items-center text-sm">
                                    <span>{{ $conge->user->prenom }} {{ $conge->user->nom }}</span>
                                    <span class="text-gray-500">{{ \Carbon\Carbon::parse($conge->date_debut)->format('d/m') }} - {{ \Carbon\Carbon::parse($conge->date_fin)->format('d/m') }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500 py-4">Aucun congé planifié pour cette année.</p>
                @endforelse
            </div>
        </div>

        <!-- Calendrier des congés -->
        <div class="bg-white rounded-lg border border-gray-200 p-6 mt-8">
             <h2 class="text-lg font-semibold mb-4">Calendrier des Congés {{ $year }}</h2>
             <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                 @for ($m = 1; $m <= 12; $m++)
                    @php
                        $date = \Carbon\Carbon::create($year, $m, 1);
                        $daysInMonth = $date->daysInMonth;
                        $startDay = $date->dayOfWeekIso; // 1 (Lundi) - 7 (Dimanche)
                    @endphp
                     <div class="p-2 border rounded-lg">
                         <h3 class="font-semibold text-center">{{ $date->translatedFormat('F') }}</h3>
                         <div class="grid grid-cols-7 text-center text-xs text-gray-500 my-2">
                             <span>Lu</span><span>Ma</span><span>Me</span><span>Je</span><span>Ve</span><span>Sa</span><span>Di</span>
                         </div>
                         <div class="grid grid-cols-7 text-center text-sm">
                             @for ($i = 1; $i < $startDay; $i++) <div></div> @endfor
                             @for ($d = 1; $d <= $daysInMonth; $d++)
                                @php
                                    $currentDay = \Carbon\Carbon::create($year, $m, $d);
                                    $onLeave = $conges->first(fn($c) => $currentDay->between($c->date_debut, $c->date_fin));
                                @endphp
                                 <div class="py-1 {{ $onLeave ? 'bg-blue-200 text-blue-800 rounded-full font-bold' : '' }}">
                                     {{ $d }}
                                 </div>
                             @endfor
                         </div>
                     </div>
                 @endfor
             </div>
        </div>
    </div>
</x-app-layout>
