@extends('statistiques.accueil') <!-- Utilisez le layout que vous avez spécifié -->

@section('content')
    <div class="container">
        <h1 class="mb-4">Commandes en cours</h1>

        @if($commandes->isEmpty())
            <div class="alert alert-info">
                Aucune commande en cours pour le moment.
            </div>
        @else
            <div class="row">
                @foreach($commandes as $commande)
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    Commande #{{ $commande->id }}
                                    <span class="badge bg-{{ $commande->statut === 'en-cours' ? 'warning' : 'secondary' }} float-end">
                                        {{ ucfirst($commande->statut) }}
                                    </span>
                                </h5>
                            </div>
                            <div class="card-body">
                                <p><strong>Date :</strong> {{ $commande->created_at->format('d/m/Y H:i') }}</p>
                                <p><strong>Total :</strong> {{ number_format($commande->total, 2) }} FCFA</p>

                                <!-- Afficher les articles de la commande -->
                                <h6>Articles :</h6>
                                <ul class="list-unstyled">
                                    @foreach($commande->burgers as $burger)
                                        <li>
                                            {{ $burger->nom }} x {{ $burger->pivot->quantite }}
                                            ({{ number_format($burger->pivot->prix_unitaire * $burger->pivot->quantite, 2) }} FCFA)
                                        </li>
                                    @endforeach
                                </ul>

                                <!-- Lien pour voir les détails de la commande -->
                                <a href="{{ route('commandes.show', $commande) }}" class="btn btn-info">
                                    Voir les détails
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
