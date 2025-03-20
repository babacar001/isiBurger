@extends('statistiques.accueil')

@section('content')
    <div class="container">
        <h1 class="mb-4">Catalogue des Burgers</h1>

        <!-- Formulaire de filtres -->
        <form action="{{ route('catalogue') }}" method="GET" class="mb-4">
            <div class="row">
                <!-- Filtre par nom -->
                <div class="col-md-4">
                    <input type="text" name="nom" class="form-control" placeholder="Nom du burger" value="{{ request()->get('nom') }}">
                </div>

                <!-- Filtre par prix -->
                <div class="col-md-4">
                    <input type="number" name="prix_min" class="form-control" placeholder="Prix minimum" value="{{ request()->get('prix_min') }}" min="0">
                </div>
                <div class="col-md-4">
                    <input type="number" name="prix_max" class="form-control" placeholder="Prix maximum" value="{{ request()->get('prix_max') }}" min="0">
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Appliquer les filtres</button>
                </div>
            </div>
        </form>

        <div class="row">
            @foreach($burgers as $burger)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        @if($burger->image)
                            <img src="{{ asset('storage/' . $burger->image) }}" class="card-img-top" alt="{{ $burger->nom }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $burger->nom }}</h5>
                            <p class="card-text">{{ $burger->description }}</p>
                            <p class="card-text">
                                <strong>Prix : </strong>{{ number_format($burger->prix, 2) }} FCFA
                            </p>
                        </div>
                        <div class="card-footer bg-transparent">
                            <form action="{{ route('commandes.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="burgers[0][id]" value="{{ $burger->id }}">
                                <div class="input-group">
                                    <input type="number" name="burgers[0][quantite]" class="form-control" value="1" min="1" max="{{ $burger->stock }}">
                                    <button type="submit" class="btn btn-primary">Commander</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
