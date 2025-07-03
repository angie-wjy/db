@extends('layouts.customer')
@section('title', 'Category')
@section('content')
    <div class="px-6 py-2">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
            <h2 class="text-2xl font-bold text-gray-800">List Product</h2>

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


        {{-- Grid Produk --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-5">
            @foreach ($dataProd as $prod)
                <div
                    class="bg-white border border-gray-200 rounded-xl shadow hover:shadow-lg transition duration-200 overflow-hidden flex flex-col">
                    <a href="/product/detail/{{ $prod->id }}" class="flex flex-col h-full">
                        {{-- Gambar dengan ukuran tetap --}}
                        <div class="h-40 bg-gray-100 flex items-center justify-center">
                            <img src="{{ asset('storage/' . $prod->image) }}"
                                alt="{{ $prod->name }}"
                                class="max-h-full max-w-full object-contain p-2">
                            </div>

                        {{-- Konten card --}}
                        <div class="p-3 flex flex-col justify-between flex-grow">
                            <h3 class="text-sm font-semibold text-gray-800 text-center mb-2">
                                {{ Str::limit($prod->name, 40) }}</h3>
                            <p class="text-orange-600 font-bold text-sm text-center">
                                Rp{{ number_format($prod->price, 0, ',', '.') }}
                                </p>
                            </div>
                        </a>
                    </div>
            @endforeach
            </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-8 flex justify-center">
        {{ $dataProd->links('pagination::tailwind') }}
        </div>
    </div>
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Tailwind Utilities --}}
    <style>
        .btn-filter {
            @apply px-4 py-2 bg-gray-100 hover:bg-yellow-300 text-sm text-gray-700 rounded transition shadow-sm;
        }
        nav {
            position: static !important;
        }
    </style>
@endsection
