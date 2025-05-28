@extends('layouts.backoffice')
@section('title', 'Edit Product')
@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Edit Product</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="#">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Product</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Edit Product</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Product</h4>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <p class="alert alert-success">{{ session('success') }}</p>
                        @endif
                        @if (session('error'))
                            <p class="alert alert-danger">{{ session('error') }}</p>
                        @endif
                        <form action="{{ route('admin.product.update', $product->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="input-group mb-3">
                                <span class="input-group-text">Nama</span>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name', $product->name) }}">
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Harga</span>
                                        <input type="text" class="form-control" id="price" name="price"
                                            value="{{ old('price', $product->price) }}">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Category</span>
                                        <select class="form-select" id="category" name="category_id">
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                    {{ $category->brand }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-floating mb-3">
                                <textarea class="form-control" placeholder="deskripsi" name="description" id="description" style="height: 100px">{{ old('description', $product->description) }}</textarea>
                                <label for="floatingTextarea2">Deskripsi</label>
                            </div>
                            <div class="mb-3">
                                <label style="font-weight: bold;">Gambar</label>
                                <input class="form-control" type="file" id="image" name="image">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="Gambar Produk" width="100"
                                        class="mt-3">
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="{{ route('admin.product.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
