@extends('statistiques.index')

@section('title', 'Mes Commandes')

@section('content')
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-6">Mes Commandes</h2>

        @if($orders->count() > 0)
            <div class="space-y-6">
                @foreach($orders as $order)
                    <div class="border rounded-lg p-4">
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <h3 class="text-lg font-semibold">Commande #{{ $order->id }}</h3>
                                <p class="text-gray-600">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div class="flex items-center">
                        <span class="px-3 py-1 rounded-full text-sm
                            @if($order->status === 'delivered') bg-green-100 text-green-800
                            @elseif($order->status === 'preparing') bg-yellow-100 text-yellow-800
                            @elseif($order->status === 'pending') bg-gray-100 text-gray-800
                            @endif">
                            {{ __("orders.status.{$order->status}") }}
                        </span>
                            </div>
                        </div>

                        <div class="space-y-2">
                            @foreach($order->items as $item)
                                <div class="flex justify-between items-center">
                                    <span>{{ $item->burger->name }} x {{ $item->quantity }}</span>
                                    <span>{{ number_format($item->price * $item->quantity, 2) }} FCFA</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4 pt-4 border-t flex justify-between items-center">
                            <span class="font-bold">Total</span>
                            <span class="font-bold">{{ number_format($order->total_amount, 2) }} €</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        @else
            <p class="text-gray-600">Vous n'avez pas encore de commandes.</p>
            <a href="{{ route('home') }}" class="mt-4 inline-block text-orange-500 hover:text-orange-600">
                Commander maintenant
            </a>
        @endif
    </div>
@endsection
