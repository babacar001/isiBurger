{{-- resources/views/pdf/facture.blade.php --}}
    <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Facture - Commande #{{ $commande->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #333;
            margin-bottom: 5px;
        }
        .info {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border-bottom: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
        .total {
            text-align: right;
            font-weight: bold;
            font-size: 16px;
            margin-top: 20px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            color: #777;
            font-size: 12px;
        }
    </style>
</head>
<body>
<div class="header">
    <h1>FACTURE</h1>
    <p>Commande #{{ $commande->id }}</p>
    <p>Date: {{ $commande->updated_at->format('d/m/Y') }}</p>
</div>

<div class="info">
    <strong>Client:</strong><br>
    {{ $commande->user->name }}<br>
    {{ $commande->user->email }}
</div>

<table>
    <thead>
    <tr>
        <th>Produit</th>
        <th>Quantité</th>
        <th>Prix unitaire</th>
        <th>Total</th>
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

<div class="total">
    Total: {{ number_format($commande->total / 100, 2) }} FCFA
</div>

<div class="footer">
    Merci pour votre commande !<br>
    {{ config('ISI Burger') }}
</div>
</body>
</html>
