@extends('layouts.customer')
@section('title', 'Category: ' . $category->name)
@section('content')
<div class="container my-5">
    <h2 class="mb-4">Category: {{ $category->name }}</h2>
    <div class="row">
        @forelse ($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">Rp.{{ number_format($product->price, 0, 0, '.') }}</p>
                        <a href="/product/{{ $product->id }}" class="btn btn-warning">Lihat Detail</a>
                    </div>
                </div>
            </div>
        @empty
            <p>Tidak ada produk dalam kategori ini.</p>
        @endforelse
    </div>
</div>
@endsection
