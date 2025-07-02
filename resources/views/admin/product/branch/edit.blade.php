@extends('layouts.backoffice')
@section('title', 'Edit Branch Product')
@section('content')
<div class="page-inner">
    <div class="page-header">
        <h3>Edit Branch Product</h3>
        <ul class="breadcrumbs mb-3">
            <li class="nav-home"><a href="#"><i class="icon-home"></i></a></li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="{{ route('admin.product.branch.index') }}">Branch Products</a></li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item">Edit Branch Products</li>
        </ul>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.product.branch.update', $productBranch->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group mb-3">
                    <label for="products_id">Product</label>
                    <select name="products_id" id="products_id" class="form-control" required>
                        <option value="">-- Select Product --</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" {{ $product->id == $productBranch->products_id ? 'selected' : '' }}>
                                {{ $product->name }} ({{ $product->code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="branches_id">Branch</label>
                    <select name="branches_id" id="branches_id" class="form-control" required>
                        <option value="">-- Select Branch --</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}" {{ $branch->id == $productBranch->branches_id ? 'selected' : '' }}>
                                {{ $branch->mall }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="stock">Stock</label>
                    <input type="number" name="stock" id="stock" class="form-control" min="0" value="{{ old('stock', $productBranch->stock) }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Update Branch Product</button>
                <a href="{{ route('admin.product.branch.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
