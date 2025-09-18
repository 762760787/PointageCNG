{{-- resources/views/admin/exports/rapports_pdf.blade.php --}}
<!DOCTYPE html>
<html>
<head><style>body{font-family:sans-serif;}table{width:100%;border-collapse:collapse;}th,td{border:1px solid #ddd;padding:8px;}th{background-color:#f2f2f2;}</style></head>
<body>
    <h1>Rapports des Heures Travaillées</h1>
    <h2>Rapport Mensuel - {{ now()->translatedFormat('F Y') }}</h2>
    <table><thead><tr><th>Employé</th><th>Heures Travaillées</th></tr></thead>
    <tbody>@forelse($monthlyReport as $report)<tr><td>{{$report['user']->prenom}} {{$report['user']->nom}}</td><td>{{$report['heures_travaillees']}}</td></tr>@empty<tr><td colspan="2">Aucune donnée.</td></tr>@endforelse</tbody>
    </table>
    <h2>Rapport Annuel - {{ now()->format('Y') }}</h2>
    <table><thead><tr><th>Employé</th><th>Heures Travaillées</th></tr></thead>
    <tbody>@forelse($yearlyReport as $report)<tr><td>{{$report['user']->prenom}} {{$report['user']->nom}}</td><td>{{$report['heures_travaillees']}}</td></tr>@empty<tr><td colspan="2">Aucune donnée.</td></tr>@endforelse</tbody>
    </table>
</body>
</html>