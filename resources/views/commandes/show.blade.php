@extends('statistiques.accueil')

@section('content')
<div class="col-md-6">
    <p><strong>Client :</strong> {{ $commande->user->name }}</p>
    <p><strong>Date :</strong> {{ $commande->created_at->format('d/m/Y H:i') }}</p>
    <p><strong>Statut :</strong>
        <span class="badge bg-{{ $commande->statut === 'payee' ? 'success' : 'warning' }}">
                            {{ ucfirst($commande->statut) }}
                        </span>
    </p>
</div>

    <div class="col-md-6">
        <p><strong>Total :</strong> {{ number_format($commande->total, 2) }} FCFA</p>
        @if($commande->paiement)
            <p><strong>Mode de paiement :</strong> {{ ucfirst($commande->paiement->mode_paiement) }}</p>
            <p><strong>Date de paiement :</strong> {{ $commande->paiement->created_at->format('d/m/Y H:i') }}</p>
        @endif
    </div>
</div>
</div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">Articles commandés</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>Burger</th>
                    <th>Prix unitaire</th>
                    <th>Quantité</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                @foreach($commande->burgers as $burger)
                    <tr>
                        <td>{{ $burger->nom }}</td>
                        <td>{{ number_format($burger->pivot->prix_unitaire, 2) }} FCFA</td>
                        <td>{{ $burger->pivot->quantite }}</td>
                        <td>{{ number_format($burger->pivot->prix_unitaire * $burger->pivot->quantite, 2) }} FCFA</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="3" class="text-end"><strong>Total</strong></td>
                    <td><strong>{{ number_format($commande->total, 2) }} FCFA</strong></td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

@if(!$commande->paiement && (auth()->user()->role === 'gestionnaire' || auth()->id() === $commande->user_id))
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Enregistrer le paiement</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('commandes.paiement.store', $commande) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="mode_paiement" class="form-label">Mode de paiement</label>
                    <select name="mode_paiement" id="mode_paiement" class="form-select" required>
                        <option value="especes">Espèces</option>
                        <option value="carte">Carte bancaire</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Enregistrer le paiement</button>
            </form>
        </div>
    </div>
    @endif
    </div>
    @endsection
