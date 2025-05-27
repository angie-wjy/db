@extends('layouts.customer')
@section('title', 'Detail Product')
@section('content')
    <div class="content">
        <div class="card mb-3 mx-auto p-5"
            style="max-width: 1000px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 10px;">
            <div class="row g-0">
                <div class="col-md-6">
                    <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded-start shadow-sm"
                        alt="..." style="border-radius: 10px; object-fit: cover; height: 400px;">
                </div>
                <div class="col-md-6">
                    <div class="card-body">
                        <h5 class="card-title" style="font-size: 2.5rem; font-weight: bold; color: #333;">
                            {{ $product->name }}</h5>
                        <p class="card-text" style="font-weight: bold; font-size: 2rem; color: #e60012;">
                            Rp.{{ number_format($product->price, 0, 0, '.') }}</p>

                        <p class="card-text" style="font-size: 1.2rem; color: #555; margin-top: 20px;">Description</p>
                        <p class="card-text" style="font-size: 1.1rem; color: #777; line-height: 1.6;">
                            {{ $product->description }}</p>

                        <form action="{{ route('customer.product.add', $product->id) }}" method="post" class="mt-4">
                            @csrf
                            <div class="input-group">
                                <span class="input-group-text"
                                    style="background-color: #f8f9fa; font-weight: bold;">Jumlah</span>
                                <input type="number" min="1" value="1" name="jumlah" class="form-control"
                                    style="max-width: 6rem; border-radius: 5px;">
                                <button type="submit" class="btn btn-warning"
                                    style="border-radius: 5px; font-weight: bold; padding-left: 20px; padding-right: 20px;">
                                    <i class="ri-shopping-cart-line"> Add to cart</i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
