@extends('statistiques.accueil')

@section('content')
    <div class="container">
        <h1 class="mb-4">Tableau de bord client </h1>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Mes dernières commandes</h5>
                    </div>
                    <div class="card-body">
                        @if($mesCommandes->isEmpty())
                            <p class="text-muted">Vous n'avez pas encore passé de commande.</p>
                        @else
                            <div class="list-group">
                                @foreach($mesCommandes as $commande)
                                    <a href="{{ route('commandes.show', $commande) }}" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Commande #{{ $commande->id }}</h6>
                                            <small>{{ $commande->created_at->format('d/m/Y H:i') }}</small>
                                        </div>
                                        <p class="mb-1">Total : {{ number_format($commande->total, 2) }} FCFA</p>
                                        <small class="text-muted">
                                            Statut :
                                            <span class="badge bg-{{ $commande->statut === 'payee' ? 'success' : 'warning' }}">
                                            {{ ucfirst($commande->statut) }}
                                        </span>
                                        </small>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('mes-commandes') }}" class="btn btn-primary">Voir toutes mes commandes</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Actions rapides</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('catalogue') }}" class="btn btn-primary">
                                Commander un burger
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
