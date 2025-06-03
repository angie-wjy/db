@extends('layouts.backoffice')
@section('title', 'Add Products')
@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Smile Gift Shop</h3>
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
                    <a href="#">Products</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Add Products +</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Add Products</h4>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <p class="alert alert-success">{{ session('success') }}</p>
                        @endif
                        @if (session('error'))
                            <p class="alert alert-danger">{{ session('error') }}</p>
                        @endif
                        <div class="table-responsive">
                            <div class="row p-3">
                                <div class="col">
                                    <form action="{{ route('admin.product.create') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">Code</span>
                                                    <input type="text" class="form-control" id="code"
                                                        name="code">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">Name</span>
                                                    <input type="text" class="form-control" id="name"
                                                        name="name">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">Price</span>
                                                    <input type="text" class="form-control" id="price"
                                                        name="price">
                                                </div>
                                                @error('price')
                                                    <p class="alert alert-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="col">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">Stock</span>
                                                    <input type="number" class="form-control" id="stock" name="stock"
                                                        min="0">
                                                </div>
                                                @error('stock')
                                                    <p class="alert alert-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="row">
                                                <div class="col">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text">Category</span>
                                                        <select class="form-select" aria-label="Default select example"
                                                            id="category" name="categories_id">
                                                            @foreach ($categories as $category)
                                                                <option value="{{ $category->id }}">{{ $category->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('category_id')
                                                        <p class="alert alert-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text">Theme</span>
                                                        <select class="form-select" aria-label="Default select example"
                                                            id="theme" name="product_themes_id">
                                                            @foreach ($themes as $theme)
                                                                <option value="{{ $theme->id }}">{{ $theme->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('product_theme_id')
                                                        <p class="alert alert-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text">Size</span>
                                                        <select class="form-select" aria-label="Default select example"
                                                            id="size" name="product_sizes_id">
                                                            @foreach ($sizes as $size)
                                                                <option value="{{ $size->id }}">{{ $size->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('product_size_id')
                                                        <p class="alert alert-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <textarea class="form-control" placeholder="deskripsi" name="description" id="description" style="height: 100px"></textarea>
                                            <label for="floatingTextarea2">Description</label>
                                        </div>
                                        @error('description')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                        <div class="mb-3">
                                            <label style="font-weight: bold;color: white;">Image</label>
                                            <input class="form-control" type="file" id="image" name="image">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
