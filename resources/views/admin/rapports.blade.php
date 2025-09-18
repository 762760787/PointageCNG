<x-app-layout>
    <x-slot name="title">
        Rapports des Heures
    </x-slot>

    <div class="p-4 sm:p-6 lg:p-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Rapports des Heures Travaillées</h1>
            <!-- Boutons d'Export -->
            <div class="flex gap-4 mt-4 sm:mt-0">
                <a href="{{ route('admin.rapports.export', 'pdf') }}" class="inline-flex items-center px-3 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500">Exporter en PDF</a>
                {{-- <a href="#" class="inline-flex items-center px-3 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500">Exporter en Excel</a> --}}
            </div>
        </div>

        <!-- Sections des rapports -->
        <div class="space-y-6">
            <!-- Rapport Mensuel -->
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                <div class="p-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800">Rapport Mensuel - {{ now()->translatedFormat('F Y') }}</h2>
                </div>
                <div class="p-4">
                    <div class="overflow-x-auto rounded-lg border">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employé</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Heures Travaillées</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($monthlyReport as $report)
                                    <tr>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ $report['user']->prenom }} {{ $report['user']->nom }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">{{ $report['heures_travaillees'] }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="px-4 py-4 text-center text-sm text-gray-500">Aucune donnée de pointage pour ce mois.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Rapport Annuel -->
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                <div class="p-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800">Rapport Annuel - {{ now()->format('Y') }}</h2>
                </div>
                <div class="p-4">
                     <div class="overflow-x-auto rounded-lg border">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employé</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Heures Travaillées</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($yearlyReport as $report)
                                    <tr>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ $report['user']->prenom }} {{ $report['user']->nom }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">{{ $report['heures_travaillees'] }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="px-4 py-4 text-center text-sm text-gray-500">Aucune donnée de pointage pour cette année.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

