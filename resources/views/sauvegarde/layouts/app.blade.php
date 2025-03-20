<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Burger House - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
<nav class="bg-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="text-xl font-bold text-orange-500">
                    Burger House
                </a>
            </div>
            <div class="flex items-center">
                @auth
                    @if(auth()->user()->role === 'gestionnaire')
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-orange-500 px-3 py-2">
                            Dashboard
                        </a>
                    @endif
                    <a href="{{ route('orders.index') }}" class="text-gray-700 hover:text-orange-500 px-3 py-2">
                        Mes Commandes
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-orange-500 px-3 py-2">
                            Déconnexion
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-orange-500 px-3 py-2">
                        Connexion
                    </a>
                    <a href="{{ route('register') }}" class="text-gray-700 hover:text-orange-500 px-3 py-2">
                        Inscription
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    @yield('content')
</main>
</body>
</html>
