<x-app-layout>
    <x-slot name="title">
        Historique des Pointages
    </x-slot>

    <div class="p-4 sm:p-6 lg:p-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Historique des Pointages</h1>
            <!-- Boutons d'Export -->
            <div class="flex gap-4 mt-4 sm:mt-0">
                <a href="{{ route('admin.historique.export', 'pdf') }}" class="inline-flex items-center px-3 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500">Exporter en PDF</a>
                <a href="{{ route('admin.historique.export', 'excel') }}" class="inline-flex items-center px-3 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500">Exporter en Excel</a>
            </div>
        </div>

        <!-- Sections hebdomadaires -->
        <div class="space-y-6">
            @forelse($weeklyHistory as $weekLabel => $days)
                <div x-data="{ open: {{ $loop->first ? 'true' : 'false' }} }" class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div @click="open = !open" class="p-4 cursor-pointer flex justify-between items-center hover:bg-gray-50">
                        <h2 class="text-lg font-semibold text-gray-800">{{ $weekLabel }}</h2>
                        <svg class="w-6 h-6 transform transition-transform text-gray-500" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </div>
                    <div x-show="open" x-transition class="p-4 border-t border-gray-200 space-y-4">
                        @php
                            $dayMap = [1 => 'Lundi', 2 => 'Mardi', 3 => 'Mercredi', 4 => 'Jeudi', 5 => 'Vendredi', 6 => 'Samedi', 7 => 'Dimanche'];
                        @endphp
                        @foreach($dayMap as $dayNumber => $dayName)
                            @if(isset($days[$dayNumber]) && $days[$dayNumber]->isNotEmpty())
                                <div class="day-section">
                                    <h3 class="font-semibold mb-2 text-md text-gray-700">{{ $dayName }}</h3>
                                    <div class="overflow-x-auto rounded-lg border">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prénom & Nom</th>
                                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Arrivée</th>
                                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pause</th>
                                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Départ</th>
                                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Observation</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach($days[$dayNumber] as $pointage)
                                                    <tr>
                                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ optional($pointage->user)->prenom }} {{ optional($pointage->user)->nom }}</td>
                                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($pointage->heure_arrivee)->format('H:i') }}</td>
                                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">13:30 - 14:30</td>
                                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ $pointage->heure_depart ? \Carbon\Carbon::parse($pointage->heure_depart)->format('H:i') : '--:--' }}</td>
                                                        <td class="px-4 py-4 whitespace-nowrap text-sm">
                                                            @php $limiteRetard = \Carbon\Carbon::parse($pointage->date)->setHour(9)->setMinute(0); @endphp
                                                            @if(\Carbon\Carbon::parse($pointage->heure_arrivee)->gt($limiteRetard))
                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">En retard</span>
                                                            @else
                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">À l'heure</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg border border-gray-200 p-6 text-center text-gray-500">
                    <p>Aucun historique de pointage disponible.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>

