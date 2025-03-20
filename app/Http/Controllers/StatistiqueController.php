<?php
namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;

class StatistiqueController extends Controller
{
public function index()
{
// Commandes du jour
$commandesJour = Commande::whereDate('created_at', Carbon::today())->count();

// Chiffre d'affaires du jour
$caJour = Commande::whereDate('created_at', Carbon::today())
->where('statut', 'payee')
->sum('total');

// Burgers les plus vendus
$burgersPopulaires = DB::table('commande_details')
->join('burgers', 'commande_details.burger_id', '=', 'burgers.id')
->select('burgers.nom', DB::raw('SUM(commande_details.quantite) as total_vendus'))
->groupBy('burgers.id', 'burgers.nom')
->orderByDesc('total_vendus')
->limit(5)
->get();

// Statistiques mensuelles
$statsParMois = Commande::where('statut', 'payee')
->select(
DB::raw("TO_CHAR(created_at, 'YYYY-MM') as mois"),
DB::raw('COUNT(*) as total_commandes'),
DB::raw('SUM(total) as chiffre_affaires')
)
->groupBy(DB::raw("TO_CHAR(created_at, 'YYYY-MM')"))
->orderBy(DB::raw("TO_CHAR(created_at, 'YYYY-MM')"), 'desc')
->limit(12)
->get();

// Extraction des données pour le graphique
$labelsCommandes = $statsParMois->pluck('mois')->toArray();
$totalCommandes = $statsParMois->pluck('total_commandes')->toArray();
$chiffreAffaires = $statsParMois->pluck('chiffre_affaires')->toArray();

    return view('statistiques.index', compact(
        'commandesJour',
        'caJour',
        'burgersPopulaires',
        'statsParMois',
        'labelsCommandes',
        'totalCommandes',
        'chiffreAffaires'
    ));
}
}
