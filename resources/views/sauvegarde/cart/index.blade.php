@extends('statistiques.index')

@section('title', 'Panier')

@section('content')
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-6">Mon Panier</h2>

        @if($cartItems->count() > 0)
            <div class="space-y-4">
                @foreach($cartItems as $item)
                    <div class="flex items-center justify-between border-b pb-4">
                        <div class="flex items-center">
                            <img src="{{ $item->burger->image }}" alt="{{ $item->burger->name }}"
                                 class="w-16 h-16 object-cover rounded">
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold">{{ $item->burger->name }}</h3>
                                <p class="text-gray-600">{{ number_format($item->burger->price, 2) }} FCFA</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center">
                                @csrf
                                @method('PATCH')
                                <button type="submit" name="action" value="decrease"
                                        class="px-2 py-1 bg-gray-200 rounded-l">-
                                </button>
                                <span class="px-4 py-1 bg-gray-100">{{ $item->quantity }}</span>
                                <button type="submit" name="action" value="increase"
                                        class="px-2 py-1 bg-gray-200 rounded-r">+
                                </button>
                            </form>
                            <form action="{{ route('cart.remove', $item) }}" method="POST" class="ml-4">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach

                <div class="mt-6 flex justify-between items-center">
                    <div class="text-lg font-bold">
                        Total: {{ number_format($total, 2) }} FCFA
                    </div>
                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-orange-500 text-white px-6 py-2 rounded-md hover:bg-orange-600">
                            Commander
                        </button>
                    </form>
                </div>
            </div>
        @else
            <p class="text-gray-600">Votre panier est vide.</p>
            <a href="{{ route('home') }}" class="mt-4 inline-block text-orange-500 hover:text-orange-600">
                Retourner à la carte
            </a>
        @endif
    </div>
@endsection
