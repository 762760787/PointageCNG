<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pointage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\HistoriqueExport;

class DashboardController extends Controller
{
    public function index()
    {

        $allEmployees = User::where('role', 'employe')->get();
        $totalEmployes = $allEmployees->count();

        //dd($totalEmployes);
        // Récupérer tous les pointages d'aujourd'hui
        $pointagesDuJour = Pointage::with('user')
            ->where('date', Carbon::today())
            ->orderBy('heure_arrivee', 'desc')
            ->get();

        // --- NOUVEAU: Calcul des 4 statistiques ---

        // 1. Présents : ceux qui ont pointé l'arrivée mais pas encore le départ.
        $presents = $pointagesDuJour->whereNull('heure_depart')->count();

        // 2. En retard : ceux arrivés après 9h00 (vous pouvez changer cette heure)
        $heureLimiteArrivee = Carbon::today()->setHour(9)->setMinute(0)->setSecond(0);
        $enRetard = $pointagesDuJour
            ->where('heure_arrivee', '>', $heureLimiteArrivee)
            ->count();

        // 3. Absents : le total des employés moins ceux qui ont pointé aujourd'hui.
        $employesPresentsIds = $pointagesDuJour->pluck('user_id')->unique();
        $absents = $allEmployees->whereNotIn('id', $employesPresentsIds)->count();

        // 4. Total : déjà calculé ($totalEmployes)

        // Envoyer toutes les données à la vue
        return view('admin.dashboard', compact(
            'pointagesDuJour',
            'totalEmployes',
            'presents',
            'enRetard',
            'absents',
            'allEmployees'
        ));
    }

    public function showQrCodes()
    {
        return view('admin.qrcodes');
    }


    /**
     * NOUVEAU: Affiche la page dédiée à l'historique des pointages.
     */
    public function historique()
    {
        $allPointages = Pointage::with('user')->orderBy('date', 'desc')->get();

        $pointagesByWeek = $allPointages->groupBy(function ($pointage) {
            // On groupe par le début de la semaine (Lundi) pour être précis
            return Carbon::parse($pointage->date)->startOfWeek(Carbon::MONDAY)->format('Y-m-d');
        });

        $weeklyHistory = [];
        foreach ($pointagesByWeek as $weekStartDate => $pointages) {
            $weekLabel = "Semaine du " . Carbon::parse($weekStartDate)->translatedFormat('d F Y');

            // --- CORRECTION APPLIQUÉE ICI ---
            // On groupe par le numéro du jour (1 pour Lundi, 7 pour Dimanche)
            $pointagesByDay = $pointages->groupBy(function ($p) {
                return Carbon::parse($p->date)->format('N');
            });

            $weeklyHistory[$weekLabel] = $pointagesByDay;
        }

        return view('admin.historique', compact('weeklyHistory'));
    }

    /**
     * NOUVEAU: Affiche la page dédiée aux rapports mensuels et annuels.
     */
    // --- Logique de rapport améliorée ---
    public function rapports()
    {
        // On n'a plus besoin de pré-charger les employés. La fonction de rapport s'en charge.
        $monthlyReport = $this->generateReport('month');
        $yearlyReport = $this->generateReport('year');

        return view('admin.rapports', compact('monthlyReport', 'yearlyReport'));
    }

    private function generateReport($period)
    {
        $start = $period === 'month' ? Carbon::now()->startOfMonth() : Carbon::now()->startOfYear();
        $end = $period === 'month' ? Carbon::now()->endOfMonth() : Carbon::now()->endOfYear();

        // On charge les pointages terminés AVEC les informations de l'utilisateur associé
        $pointages = Pointage::with('user')
            ->whereBetween('date', [$start, $end])
            ->whereNotNull('heure_arrivee')
            ->whereNotNull('heure_depart')
            ->get();

        // On groupe les pointages trouvés par l'ID de l'utilisateur
        $pointagesByUser = $pointages->groupBy('user_id');

        $reportData = [];
        // On boucle sur chaque groupe de pointages par utilisateur
        foreach ($pointagesByUser as $userId => $userPointages) {
            // On s'assure que l'utilisateur existe et n'est pas un admin
            if ($userPointages->first()->user && $userPointages->first()->user->role == 'employe') {
                $totalSeconds = $userPointages->reduce(function ($carry, $pointage) {
                    $arrivee = Carbon::parse($pointage->heure_arrivee);
                    $depart = Carbon::parse($pointage->heure_depart);
                    $duration = $depart->diffInSeconds($arrivee) - 3600; // Soustrait 1h de pause
                    return $carry + ($duration > 0 ? $duration : 0);
                }, 0);

                if ($totalSeconds > 0) {
                    $hours = floor($totalSeconds / 3600);
                    $minutes = floor(($totalSeconds % 3600) / 60);
                    $reportData[] = [
                        'user' => $userPointages->first()->user, // On récupère l'objet User du premier pointage
                        'heures_travaillees' => sprintf('%02d:%02d', $hours, $minutes),
                    ];
                }
            }
        }
        return $reportData;
    }

    public function exportHistorique(string $type)
    {
        // Récupérer les données de l'historique
        $allPointages = \App\Models\Pointage::with('user')->orderBy('date', 'desc')->get();
        $pointagesByWeek = $allPointages->groupBy(fn($p) => \Carbon\Carbon::parse($p->date)->startOfWeek(\Carbon\Carbon::MONDAY)->format('Y-m-d'));
        $weeklyHistory = [];
        foreach ($pointagesByWeek as $weekStartDate => $pointages) {
            $weekLabel = "Semaine du " . \Carbon\Carbon::parse($weekStartDate)->translatedFormat('d F Y');
            $pointagesByDay = $pointages->groupBy(fn($p) => \Carbon\Carbon::parse($p->date)->format('N'));
            $weeklyHistory[$weekLabel] = $pointagesByDay;
        }

        if ($type === 'pdf') {
            $pdf = Pdf::loadView('admin.exports.historique_pdf', ['weeklyHistory' => $weeklyHistory]);
            return $pdf->download('historique-pointages.pdf');
        }

        if ($type === 'excel') {
            return Excel::download(new HistoriqueExport($weeklyHistory), 'historique-pointages.xlsx');
        }
    }

    public function exportRapports(string $type)
    {
        $employees = \App\Models\User::where('role', 'employer')->get();
        $monthlyReport = $this->generateReport($employees, 'month');
        $yearlyReport = $this->generateReport($employees, 'year');

        if ($type === 'pdf') {
            $pdf = Pdf::loadView('admin.exports.rapports_pdf', compact('monthlyReport', 'yearlyReport'));
            return $pdf->download('rapports-heures.pdf');
        }
    }
}
