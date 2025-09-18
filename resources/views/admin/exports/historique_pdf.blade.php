{{-- resources/views/admin/exports/historique_pdf.blade.php --}}
<!DOCTYPE html>
<html>
<head><style>body{font-family:sans-serif;}table{width:100%;border-collapse:collapse;}th,td{border:1px solid #ddd;padding:8px;}th{background-color:#f2f2f2;}</style></head>
<body>
    <h1>Historique des Pointages</h1>
    @foreach($weeklyHistory as $weekLabel => $days)
        <h2>{{ $weekLabel }}</h2>
        @php $dayMap = [1 => 'Lundi', 2 => 'Mardi', 3 => 'Mercredi', 4 => 'Jeudi', 5 => 'Vendredi', 6 => 'Samedi', 7 => 'Dimanche']; @endphp
        @foreach($dayMap as $dayNumber => $dayName)
            @if(isset($days[$dayNumber]))
                <h3>{{ $dayName }}</h3>
                <table><thead><tr><th>Employé</th><th>Arrivée</th><th>Départ</th></tr></thead>
                <tbody>@foreach($days[$dayNumber] as $pointage)<tr><td>{{$pointage->user->prenom}} {{$pointage->user->nom}}</td><td>{{ \Carbon\Carbon::parse($pointage->heure_arrivee)->format('H:i') }}</td><td>{{ $pointage->heure_depart ? \Carbon\Carbon::parse($pointage->heure_depart)->format('H:i') : '--:--' }}</td></tr>@endforeach</tbody>
                </table>
            @endif
        @endforeach
    @endforeach
</body>
</html>