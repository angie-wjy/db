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
                        {{-- Global Success/Error Alerts --}}
                        @if (session('success'))
                            <p class="alert alert-success">{{ session('success') }}</p>
                        @endif
                        @if (session('error'))
                            <p class="alert alert-danger">{{ session('error') }}</p>
                        @endif

                        {{-- Alert for all fields not filled (Laravel validation error summary) --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <h4 class="alert-heading">Please fill in all required fields!</h4> {{-- Translated --}}
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
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
                                                    <input type="text" class="form-control" id="code" name="code"
                                                        required value="{{ old('code') }}">
                                                </div>
                                                @error('code')
                                                    <p class="alert alert-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="col">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">Name</span>
                                                    <input type="text" class="form-control" id="name" name="name"
                                                        required value="{{ old('name') }}">
                                                </div>
                                                @error('name')
                                                    <p class="alert alert-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="col">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">Price</span>
                                                    <input type="text" class="form-control" id="price" name="price"
                                                        required value="{{ old('price') }}">
                                                </div>
                                                @error('price')
                                                    <p class="alert alert-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">Category</span>
                                                    <select class="form-select" aria-label="Default select example"
                                                        id="category" name="categories_id" required>
                                                        <option value="">Select Category</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}"
                                                                {{ old('categories_id') == $category->id ? 'selected' : '' }}>
                                                                {{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('categories_id')
                                                    <p class="alert alert-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="col">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">Theme</span>
                                                    <select class="form-select" aria-label="Default select example"
                                                        id="theme" name="product_themes_id" required>
                                                        <option value="">Select Theme</option> {{-- Translated --}}
                                                        @foreach ($themes as $theme)
                                                            <option value="{{ $theme->id }}"
                                                                {{ old('product_themes_id') == $theme->id ? 'selected' : '' }}>
                                                                {{ $theme->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('product_themes_id')
                                                    <p class="alert alert-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="col">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">Size</span>
                                                    <select class="form-select" aria-label="Default select example"
                                                        id="size" name="product_sizes_id" required>
                                                        <option value="">Select Size</option> {{-- Translated --}}
                                                        @foreach ($sizes as $size)
                                                            <option value="{{ $size->id }}"
                                                                {{ old('product_sizes_id') == $size->id ? 'selected' : '' }}>
                                                                {{ $size->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('product_sizes_id')
                                                    <p class="alert alert-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <textarea class="form-control" placeholder="deskripsi" name="description" id="description" style="height: 100px"
                                                required>{{ old('description') }}</textarea>
                                            <label for="description">Description</label>
                                        </div>
                                        @error('description')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                        <div class="mb-3">
                                            <label for="image" style="font-weight: bold;color: black;">Image</label>
                                            <input class="form-control" type="file" id="image" name="image"
                                                required>
                                        </div>
                                        @error('image')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
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
