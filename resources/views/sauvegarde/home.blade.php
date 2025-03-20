@extends('statistiques.index')

@section('title', 'Accueil')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($burgers as $burger)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <img src="{{ $burger->image }}" alt="{{ $burger->name }}" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-xl font-semibold text-gray-900">{{ $burger->name }}</h3>
                    <p class="mt-2 text-gray-600">{{ $burger->description }}</p>
                    <div class="mt-4 flex items-center justify-between">
                        <span class="text-lg font-bold text-orange-500">{{ number_format($burger->price, 2) }} FCFA</span>
                        <form action="{{ route('cart.add', $burger) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded-md hover:bg-orange-600">
                                Ajouter au panier
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
