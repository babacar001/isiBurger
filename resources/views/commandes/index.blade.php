@extends('statistiques.accueil')

@section('content')
    <div class="container">
        <h1 class="mb-4">Liste des Commandes</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>N° Commande</th>
                    <th>Client</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($commandes as $commande)
                    <tr>
                        <td>#{{ $commande->id }}</td>
                        <td>{{ $commande->user->name }}</td>
                        <td>{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ number_format($commande->total, 2) }} FCFA</td>
                        <td>
                        <span class="badge bg-{{ $commande->statut === 'payee' ? 'success' : 'warning' }}">
                            {{ ucfirst($commande->statut) }}
                        </span>
                        </td>
                        <td>
                            <a href="{{ route('commandes.show', $commande) }}" class="btn btn-sm btn-info">
                                Détails
                            </a>
                            @if($commande->statut !== 'payee')
                                <form action="{{ route('commandes.update-statut', $commande) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <select name="statut" class="form-select form-select-sm d-inline-block w-auto" onchange="this.form.submit()">
                                        <option value="en_attente" {{ $commande->statut === 'en_attente' ? 'selected' : '' }}>En attente</option>
                                        <option value="en_preparation" {{ $commande->statut === 'en_preparation' ? 'selected' : '' }}>En préparation</option>
                                        <option value="prete" {{ $commande->statut === 'prete' ? 'selected' : '' }}>Prête</option>
                                    </select>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
