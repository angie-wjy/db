@extends('layouts.backoffice')
@section('title', 'Branch Products')
@section('content')
<div class="page-inner">
    <div class="page-header">
        <h3 class="fw-bold mb-3">Smile Gift Shop</h3>
        <ul class="breadcrumbs mb-3">
            <li class="nav-home"><a href="#"><i class="icon-home"></i></a></li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Branch Products</a></li>
        </ul>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Branch Products</h4>
                <a href="{{ route('admin.product.branch.add') }}">
                    <button class="btn btn-primary">Add Branch Products +</button>
                </a>
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
                                <th>Branch</th>
                                <th>Product Code</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($producthasbranches as $pb)
                                <tr>
                                    <td>{{ $pb->branch->mall ?? '-' }}</td>
                                    <td>{{ $pb->product->code ?? '-' }}</td>
                                    <td>{{ $pb->product->name ?? '-' }}</td>
                                    <td>{{ number_format($pb->product->price ?? 0, 0, ',', '.') }}</td>
                                    <td>{{ $pb->stock }}</td>
                                    <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        {{ $pb->product->description ?? '-' }}
                                    </td>
                                    <td>
                                        @if ($pb->product && $pb->product->image)
                                            <img src="{{ Storage::url($pb->product->image) }}" width="100px">
                                        @else
                                            <span>No Image</span>
                                        @endif
                                    </td>
                                    <td>{{ $pb->created_at->format('d-m-Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.product.branch.edit', $pb->id) }}">
                                            <button class="btn btn-warning btn-sm">Edit</button>
                                        </a>
                                        <form action="{{ route('admin.product.branch.delete', $pb->id) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this branch product?')">Delete</button>
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
