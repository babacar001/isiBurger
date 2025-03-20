@extends('statistiques.accueil')

@section('content')
    <div class="container">
        <h1 class="mb-4">Tableau de bord - Gestionnaire</h1>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Commandes en cours</h5>
                        <p class="card-text display-4">{{ $commandesEnCours }}</p>
                        <a href="{{ route('commandes.en-cours') }}" class="btn btn-light"> Voir les détails</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Commandes aujourd'hui</h5>
                        <p class="card-text display-4">{{ $commandesAujourdhui }}</p>
                        <a href="{{ route('commandes.index') }}" class="btn btn-light">Voir toutes les commandes</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <h5 class="card-title">Burgers en rupture</h5>
                        <p class="card-text display-4">{{ $burgersEnRupture }}</p>
                        <a href="{{ route('burgers.index') }}" class="btn btn-light">Gérer les stocks</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
