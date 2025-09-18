<?php
// app/Exports/HistoriqueExport.php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class HistoriqueExport implements FromCollection, WithHeadings, WithTitle
{
    protected $weeklyHistory;

    public function __construct(array $weeklyHistory)
    {
        $this->weeklyHistory = $weeklyHistory;
    }

    public function collection()
    {
        $data = collect();
        $dayMap = [1 => 'Lundi', 2 => 'Mardi', 3 => 'Mercredi', 4 => 'Jeudi', 5 => 'Vendredi', 6 => 'Samedi', 7 => 'Dimanche'];

        foreach ($this->weeklyHistory as $weekLabel => $days) {
            $data->push([$weekLabel, '', '', '', '']); // Ligne pour la semaine
            foreach($dayMap as $dayNumber => $dayName) {
                if(isset($days[$dayNumber])) {
                    $data->push([$dayName, '', '', '', '']); // Ligne pour le jour
                    foreach($days[$dayNumber] as $pointage) {
                        $data->push([
                            'employe' => optional($pointage->user)->prenom . ' ' . optional($pointage->user)->nom,
                            'date' => \Carbon\Carbon::parse($pointage->date)->format('d/m/Y'),
                            'arrivee' => \Carbon\Carbon::parse($pointage->heure_arrivee)->format('H:i'),
                            'depart' => $pointage->heure_depart ? \Carbon\Carbon::parse($pointage->heure_depart)->format('H:i') : '',
                            'observation' => \Carbon\Carbon::parse($pointage->heure_arrivee)->gt(\Carbon\Carbon::parse($pointage->date)->setHour(9)) ? 'En retard' : 'À l\'heure',
                        ]);
                    }
                }
            }
        }
        return $data;
    }

    public function headings(): array
    {
        return ['Employé / Date', 'Date', 'Heure Arrivée', 'Heure Départ', 'Observation'];
    }

    public function title(): string
    {
        return 'Historique des Pointages';
    }
}
