@extends('layouts.backoffice')
@section('title', 'Restock Product')
@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Restock Product</h3>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.product.restock.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="mb-3">
                            <label>Product Code</label>
                            <input type="text" class="form-control" value="{{ $product->code }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" class="form-control" value="{{ $product->name }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label>Price</label>
                            <input type="text" class="form-control" value="{{ number_format($product->price, 0, ',', '.') }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label>Restock Quantity</label>
                            <input type="number" name="quantity" class="form-control" required min="1">
                        </div>
                        <button type="submit" class="btn btn-success">Submit Restock</button>
                        <a href="{{ route('admin.product.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
