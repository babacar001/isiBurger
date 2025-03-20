<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\Burger;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
         // auth()->user()->isGestionnaire()
        $user= Auth::user();

        if ($user->hasRole('gestionnaire')) {

            $commandesEnCours = Commande::whereIn('statut', ['en_attente', 'en_preparation'])
                ->count();
            $commandesAujourdhui = Commande::whereDate('created_at', today())
                ->count();
            $burgersEnRupture = Burger::where('stock', 0)
                ->count();

            return view('dashboard.gestionnaire', compact(
                'commandesEnCours',
                'commandesAujourdhui',
                'burgersEnRupture'
            ));
        }

        $mesCommandes = Commande::where('user_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();


        return view('dashboard.client', compact('mesCommandes'));
    }
}
