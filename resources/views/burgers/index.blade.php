@extends('statistiques.accueil')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Liste des Burgers</h1>
            <a href="{{ route('burgers.create') }}" class="btn btn-primary">Ajouter un Burger</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

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
                            <p class="card-text">
                                <strong>Stock : </strong>{{ $burger->stock }}
                            </p>
                            <p class="card-text">
                                <strong>Statut : </strong>
                                @if($burger->disponible)
                                    <span class="badge bg-success">Disponible</span>
                                @else
                                    <span class="badge bg-danger">Indisponible</span>
                                @endif
                            </p>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('burgers.edit', $burger) }}" class="btn btn-warning">Modifier</a>
                                <form action="{{ route('burgers.destroy', $burger) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce burger ?')">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
