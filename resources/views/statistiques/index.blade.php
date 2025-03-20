@extends('statistiques.accueil')
@section('content')
    <div class="container">
        <h1>Statistiques</h1>

        <h2>Commandes du Jour: {{ $commandesJour }}</h2>
        <h2>Chiffre d'Affaires du Jour: {{ $caJour }} €</h2>

        <h3>Burgers les Plus Vendus</h3>
        <ul>
            @foreach ($burgersPopulaires as $burger)
                <li>{{ $burger->nom }}: {{ $burger->total_vendus }} vendus</li>
            @endforeach
        </ul>

        <h3>Statistiques Mensuelles</h3>
        <canvas id="commandesChart"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('commandesChart').getContext('2d');
        const labels = @json($labelsCommandes);
        const dataCommandes = @json($totalCommandes);
        const dataChiffreAffaires = @json($chiffreAffaires);

        const commandesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Total Commandes',
                        data: dataCommandes,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
        borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        },
        {
            label: 'Chiffre d\'Affaires',
                data: dataChiffreAffaires,
            backgroundColor: 'rgba(153, 102, 255, 0.2)',
            borderColor: 'rgba(153, 102, 255, 1)',
            borderWidth: 1
        }
        ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
        });
    </script>
@endsection


