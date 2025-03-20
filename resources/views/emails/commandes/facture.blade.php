<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de commande</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <div class="alert alert-success" role="alert">
        <h1>Confirmation de commande</h1>
        <p>Merci pour votre commande <strong>#{{ $commande->id }}</strong> !</p>
    </div>

    <h2>Détails de la commande</h2>
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th scope="col">Burger</th>
            <th scope="col">Quantité</th>
            <th scope="col">Prix unitaire</th>
            <th scope="col">Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach($commande->burgers as $burger)
            <tr>
                <td>{{ $burger->nom }}</td>
                <td>{{ $burger->pivot->quantite }}</td>
                <td>{{ number_format($burger->pivot->prix_unitaire / 100, 2) }} €</td>
                <td>{{ number_format(($burger->pivot->prix_unitaire * $burger->pivot->quantite) / 100, 2) }} €</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="my-3">
        <h4><strong>Total:</strong> {{ number_format($commande->total / 100, 2) }} FCFA</h4>
    </div>

    <p>Votre commande est actuellement en attente de traitement. Nous vous informerons dès qu'elle sera prête.</p>

    <a href="{{ route('commandes.show', $commande) }}" class="btn btn-primary">Voir ma commande</a>

    <footer class="mt-5">
        <p>Merci,<br> {{ config('app.name') }}</p>
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
