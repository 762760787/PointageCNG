<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;

class UpdateEmployeeStatusCommand extends Command
{
    protected $signature = 'app:update-employee-status';
    protected $description = 'Met à jour le statut des employés en fonction de leurs congés approuvés.';

    public function handle()
    {
        $today = Carbon::today();

        // Remettre à "Actif" les employés dont le congé est terminé
        User::where('statut', 'En congé')
            ->whereHas('conges', function ($query) use ($today) {
                $query->where('date_fin', '<', $today)->where('statut', 'Approuvé');
            })
            ->update(['statut' => 'Actif']);

        // Mettre à "En congé" les employés dont le congé commence
        User::where('statut', 'Actif')
            ->whereHas('conges', function ($query) use ($today) {
                $query->where('date_debut', '<=', $today)
                      ->where('date_fin', '>=', $today)
                      ->where('statut', 'Approuvé');
            })
            ->update(['statut' => 'En congé']);

        $this->info('Les statuts des employés ont été mis à jour avec succès.');
        return 0;
    }
}
