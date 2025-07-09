@extends('layouts.customer')
@section('title', 'Bundles')
@section('content')
    <div class="px-6 py-2">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
            <h2 class="text-2xl font-bold text-gray-800">List Bundles</h2>

            <form method="GET" action="" class="flex items-center gap-2">
                <input type="text" name="search" placeholder="Search..."
                    class="w-64 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-yellow-300 focus:border-yellow-400 text-sm">
                <button type="submit"
                    class="px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-white rounded-md text-sm font-semibold shadow">
                    Search
                </button>
            </form>
        </div>

        {{-- Filter Sort --}}
        <div class="flex flex-wrap gap-3 mb-6">
            <a href="?sort=popular" class="btn-filter">Popular</a>
            <a href="?sort=latest" class="btn-filter">Newest</a>
            <a href="?sort=bestseller" class="btn-filter">Best Seller</a>
            <a href="?sort=PRICE_UP" class="btn-filter">Price: Low to High</a>
            <a href="?sort=PRICE_DOWN" class="btn-filter">Price: High to Low</a>
        </div>

        {{-- Grid Bundles --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($bundles as $bundle)
            {{-- @dd($bundles) --}}
                <div class="bg-white border border-gray-200 rounded-xl shadow hover:shadow-lg transition duration-200 overflow-hidden p-4 flex flex-col justify-between">
                    <div class="flex gap-2 mb-3 overflow-x-auto">
                        @foreach ($bundle->products as $product)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                class="w-20 h-20 object-cover rounded">
                        @endforeach
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">{{ $bundle->name }}</h3>
                        <ul class="text-sm mb-2 text-gray-600">
                            @foreach ($bundle->products as $product)
                                <li>🧸 {{ $product->name }} ({{ $product->pivot->quantity }} pcs)</li>
                            @endforeach
                        </ul>
                        <p class="text-orange-600 font-bold mb-3">
                            Rp{{ number_format($bundle->price, 0, ',', '.') }}
                        </p>
                        <form action="{{ route('customer.bundle.buy', $bundle->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full bg-green-500 hover:bg-green-600 text-white text-sm py-2 rounded shadow">
                                Buy This Bundle
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-8 flex justify-center">
            {{ $bundles->links('pagination::tailwind') }}
        </div>
    </div>

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .btn-filter {
            @apply px-4 py-2 bg-gray-100 hover:bg-yellow-300 text-sm text-gray-700 rounded transition shadow-sm;
        }
        nav {
            position: static !important;
        }
    </style>
@endsection
