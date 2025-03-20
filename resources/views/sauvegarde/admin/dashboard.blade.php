@extends('statistiques.index')

@section('title', 'Dashboard')

@section('content')
    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-6">Commandes en cours</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($activeOrders as $order)
                    <div class="border rounded-lg p-4">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Commande #{{ $order->id }}</h3>
                            <span class="px-3 py-1 rounded-full text-sm
                        @if($order->status === 'preparing') bg-yellow-100 text-yellow-800
                        @elseif($order->status === 'ready') bg-green-100 text-green-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ __("orders.status.{$order->status}") }}
                    </span>
                        </div>

                        <div class="space-y-2 mb-4">
                            @foreach($order->items as $item)
                                <div class="flex justify-between">
                                    <span>{{ $item->burger->name }}</span>
                                    <span>x {{ $item->quantity }}</span>
                                </div>
                            @endforeach
                        </div>

                        <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="mt-4">
                            @csrf
                            @method('PATCH')
                            <div class="flex space-x-2">
                                @if($order->status === 'pending')
                                    <button type="submit" name="status" value="preparing"
                                            class="flex-1 bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600">
                                        Préparer
                                    </button>
                                @elseif($order->status === 'preparing')
                                    <button type="submit" name="status" value="ready"
                                            class="flex-1 bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
                                        Prêt
                                    </button>
                                @elseif($order->status === 'ready')
                                    <button type="submit" name="status" value="delivered"
                                            class="flex-1 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                                        Livré
                                    </button>
                                @endif
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-6">Gestion des Burgers</h2>

            <div class="mb-6">
                <a href="{{ route('admin.burgers.create') }}"
                   class="bg-orange-500 text-white px-4 py-2 rounded-md hover:bg-orange-600">
                    Ajouter un burger
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($burgers as $burger)
                    <div class="border rounded-lg overflow-hidden">
                        <img src="{{ $burger->image }}" alt="{{ $burger->name }}" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold">{{ $burger->name }}</h3>
                            <p class="text-gray-600">{{ $burger->description }}</p>
                            <p class="mt-2 font-bold">{{ number_format($burger->price, 2) }} FCFA</p>

                            <div class="mt-4 flex space-x-2">
                                <a href="{{ route('admin.burgers.edit', $burger) }}"
                                   class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                                    Modifier
                                </a>
                                <form action="{{ route('admin.burgers.destroy', $burger) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600"
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce burger ?')">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
