<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('burger.png') }}">
    <title>Gestion de Burgers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('toggle.css') }}">
    <link>
</head>
<script src="{{asset('toggle.js')}}"></script>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard2') }}">BurgerApp</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('catalogue') }}">Catalogue</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('mes-commandes') }}">Mes Commandes</a>
                    </li>
                    @if(auth()->user()->hasRole('gestionnaire'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('burgers.index') }}">Gestion Burgers</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('commandes.index') }}">Commandes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('statistiques') }}">Statistiques</a>
                        </li>
                    @endif
                @endauth
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <button id="darkModeToggle" class="btn btn-outline-light">🌙 Mode sombre</button>
                </li>

            @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Inscription</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Déconnexion</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<main>
    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>
