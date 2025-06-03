@extends('layouts.backoffice')
@section('title', 'Products')
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
            </ul>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <h4 class="card-title">Products</h4>
                        <a href="{{ route('admin.product.add') }}">
                            <button class="btn btn-primary">Add Products +</button>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <p class="alert alert-success">{{ session('success') }}</p>
                    @endif
                    @if (session('error'))
                        <p class="alert alert-danger">{{ session('error') }}</p>
                    @endif
                    <div class="table-responsive">
                        <table id="multi-filter-select" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Desc</th>
                                    <th>Image</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Desc</th>
                                    <th>Image</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $product->code }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ number_format($product->price, 0, ',', '.') }}</td>
                                        <td>{{ $product->stock }}</td>
                                        <td
                                            style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                            {{ $product->description }}</td>
                                        <td><img src='{{ Storage::url($product->image) }}' width="150px"></td>
                                        <td>{{ $product->created_at->format('d-m-Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('admin.product.edit', $product->id) }}">
                                                <button class="btn btn-primary">Edit</button>
                                            </a>
                                            <a href="{{ route('admin.product.restock.form', $product->id) }}">
                                                <button class="btn btn-warning">Restock</button>
                                            </a>
                                            <form action="{{ route('admin.product.delete', $product->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
