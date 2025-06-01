@extends('layouts.backoffice')
@section('title', 'Edit Product')
@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Smile Gift Shop</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="#"><i class="icon-home"></i></a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item"><a href="#">Products</a></li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item"><a href="#">Edit Product</a></li>
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
                        <form action="{{ route('admin.product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Code</span>
                                        <input type="text" class="form-control" name="code" value="{{ old('code', $product->code) }}">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Name</span>
                                        <input type="text" class="form-control" name="name" value="{{ old('name', $product->name) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Price</span>
                                        <input type="text" class="form-control" name="price" value="{{ old('price', $product->price) }}">
                                    </div>
                                    @error('price')<p class="alert alert-danger">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Category</span>
                                        <select class="form-select" name="category_id">
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('category_id')<p class="alert alert-danger">{{ $message }}</p>@enderror
                                </div>

                                <div class="col">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Theme</span>
                                        <select class="form-select" name="product_themes_id">
                                            @foreach ($themes as $theme)
                                                <option value="{{ $theme->id }}" {{ $product->product_themes_id == $theme->id ? 'selected' : '' }}>
                                                    {{ $theme->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('product_themes_id')<p class="alert alert-danger">{{ $message }}</p>@enderror
                                </div>

                                <div class="col">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Size</span>
                                        <select class="form-select" name="product_sizes_id">
                                            @foreach ($sizes as $size)
                                                <option value="{{ $size->id }}" {{ $product->product_sizes_id == $size->id ? 'selected' : '' }}>
                                                    {{ $size->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('product_sizes_id')<p class="alert alert-danger">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div class="form-floating mb-3">
                                <textarea class="form-control" name="description" id="description" style="height: 100px">{{ old('description', $product->description) }}</textarea>
                                <label for="description">Description</label>
                            </div>
                            @error('description')<p class="alert alert-danger">{{ $message }}</p>@enderror

                            <div class="mb-3">
                                <label style="font-weight: bold;">Image</label>
                                <input class="form-control" type="file" name="image">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="Gambar Produk" width="100" class="mt-3">
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
