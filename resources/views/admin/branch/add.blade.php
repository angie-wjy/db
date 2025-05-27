@extends('layouts.backoffice')
@section('title', 'Add Branches')
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
                    <a href="#">Branches</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Add Branches +</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Add Branches</h4>
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
                                    <form action="{{ route('admin.branch.create') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">Name</span>
                                                    <input type="text" class="form-control" id="name"
                                                        name="name">
                                                </div>
                                                @error('price')
                                                    <p class="alert alert-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="col">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">Mall</span>
                                                    <input type="text" class="form-control" id="mall"
                                                        name="mall">
                                                </div>
                                                @error('price')
                                                    <p class="alert alert-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <textarea class="form-control" placeholder="deskripsi" name="address" id="address" style="height: 100px"></textarea>
                                            <label for="floatingTextarea2">Address</label>
                                        </div>
                                        @error('description')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                        <div class="col">
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">Latitude</span>
                                                <input type="text" class="form-control" id="latitude" name="latitude">
                                            </div>
                                            @error('name')
                                                <p class="alert alert-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col">
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">Longitude</span>
                                                <input type="text" class="form-control" id="longitude" name="longitude">
                                            </div>
                                            @error('name')
                                                <p class="alert alert-danger">{{ $message }}</p>
                                            @enderror
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
