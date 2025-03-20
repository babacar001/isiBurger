<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Burger;
use App\Models\CommandeDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\CommandeConfirmation;
use App\Mail\NouvelleCommandeNotification;
use App\Mail\FactureCommande;
use App\Notifications\CommandePrete;
use Barryvdh\DomPDF\Facade\Pdf;

class CommandeController extends Controller
{
    public function index()
    {
        $commandes = Commande::with(['user', 'burgers'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('commandes.index', compact('commandes'));
    }

    public function create()
    {
        $burgers = Burger::where('disponible', true)
            ->where('stock', '>', 0)
            ->get();
        return view('commandes.create', compact('burgers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'burgers' => 'required|array',
            'burgers.*.id' => 'required|exists:burgers,id',
            'burgers.*.quantite' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();
        try {
            $total = 0;
            foreach ($validated['burgers'] as $item) {
                $burger = Burger::find($item['id']);
                if ($burger->stock < $item['quantite']) {
                    throw new \Exception("Stock insuffisant pour {$burger->nom}");
                }
                $total += $burger->prix * $item['quantite'];
            }

            $commande = Commande::create([
                'user_id' => auth()->id(),
                'total' => $total,
                'statut' => 'en_attente'
            ]);

            foreach ($validated['burgers'] as $item) {
                $burger = Burger::find($item['id']);
                CommandeDetail::create([
                    'commande_id' => $commande->id,
                    'burger_id' => $burger->id,
                    'quantite' => $item['quantite'],
                    'prix_unitaire' => $burger->prix
                ]);
                $burger->decrement('stock', $item['quantite']);
            }

            DB::commit();

            // Envoyer un email de confirmation au client
            $commande->load(['user', 'burgers']);
            Mail::to($commande->user->email)->send(new CommandeConfirmation($commande));

            // Notifier les gestionnaires de la nouvelle commande
            $gestionnaires = \App\Models\User::where('role', 'gestionnaire')->get();
            foreach ($gestionnaires as $gestionnaire) {
                Mail::to($gestionnaire->email)->send(new NouvelleCommandeNotification($commande));
            }

            return redirect()->route('commandes.show', $commande)
                ->with('success', 'Commande créée avec succès');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show(Commande $commande)
    {
        $commande->load(['user', 'burgers', 'paiement']);
        return view('commandes.show', compact('commande'));
    }

    public function updateStatut(Request $request, Commande $commande)
    {
        $validated = $request->validate([
            'statut' => 'required|in:en_attente,en_preparation,prete,payee'
        ]);

        $oldStatut = $commande->statut;
        $commande->update($validated);

        if ($validated['statut'] === 'prete' && $oldStatut !== 'prete') {
            $commande->load(['user', 'burgers']);
            $commande->user->notify(new CommandePrete($commande));
            $this->envoyerFacturePDF($commande);
        }

        return redirect()->back()->with('success', 'Statut mis à jour avec succès');
    }

    protected function envoyerFacturePDF(Commande $commande)
    {
        $commande->load(['user', 'burgers']);
        $pdf = PDF::loadView('pdf.facture', compact('commande'));
        Mail::to($commande->user->email)->send(new FactureCommande($commande, $pdf));
    }

    public function recuPDF(Commande $commande)
    {
        if (auth()->id() !== $commande->user_id && !auth()->user()->isGestionnaire()) {
            abort(403);
        }

        $commande->load(['user', 'burgers', 'paiement']);
        $pdf = PDF::loadView('commandes.recu', compact('commande'));
        return $pdf->download('facture-commande-' . $commande->id . '.pdf');
    }

    public function mesCommandes()
    {
        $commandes = Commande::where('user_id', auth()->id())
            ->with(['burgers'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('commandes.mes-commandes', compact('commandes'));
    }

    public function commandesEnCours()
    {

        $commandes = Commande::whereIn('statut', ['en_attente', 'en_preparation'])
            ->with(['user', 'burgers'])
            ->orderBy('created_at', 'asc')
            ->get();

        return view('commandes.en-cours', compact('commandes'));
    }

    public function annuler(Commande $commande)
    {
        if ($commande->statut !== 'en_attente') {
            return back()->withErrors(['error' => 'Impossible d\'annuler cette commande']);
        }

        DB::beginTransaction();
        try {
            foreach ($commande->burgers as $burger) {
                $burger->increment('stock', $burger->pivot->quantite);
            }
            CommandeDetail::where('commande_id', $commande->id)->delete();
            $commande->delete();

            DB::commit();
            return redirect()->route('mes-commandes')
                ->with('success', 'Commande annulée avec succès');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Erreur lors de l\'annulation de la commande']);
        }
    }

    public function confirmerCommande(Commande $commande)
    {

        // Envoi de l'email de confirmation
        Mail::to($commande->user->email)->send(new CommandeConfirmation($commande));

        return back()->with('success', 'Commande confirmée et email envoyé.');
    }

    public function factureCommande(Commande $commande)
    {
        // Génération du PDF de la facture
        $pdf = Pdf::loadView('pdf.facture', compact('commande'));

        // Envoi de l'email avec la facture attachée
        Mail::to($commande->user->email)->send(new FactureCommande($commande, $pdf));

        return back()->with('success', 'Facture envoyée par email.');
    }

    public function notifierCommandePrete(Commande $commande)
    {
        // Envoi de la notification (email et base de données)
        $commande->user->notify(new CommandePrete($commande));

        return back()->with('success', 'Notification envoyée à l\'utilisateur.');
    }
}
