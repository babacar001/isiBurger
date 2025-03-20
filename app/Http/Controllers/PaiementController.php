<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Commande;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    public function store(Request $request, Commande $commande)
    {



        $validated = $request->validate([
            'mode_paiement' => 'required|in:especes,carte'
        ]);

        $paiement = Paiement::create([
            'commande_id' => $commande->id,
            'montant' => $commande->total,
            'mode_paiement' => $validated['mode_paiement']
        ]);

        $commande->update(['statut' => 'payee']);

        return redirect()->route('commandes.show', $commande)
            ->with('success', 'Paiement enregistré avec succès');
    }
}
