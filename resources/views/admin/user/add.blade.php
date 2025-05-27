@extends('layouts.backoffice')
@section('title', 'Add User')
@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Smile Gift Shop</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item"><a href="{{ route('admin.user.index') }}">Users</a></li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item">Add User +</li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Add User</h4>
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
                                    <form action="{{ route('admin.user.create') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group mb-3">
                                                    <label for="role">Role</label>
                                                    <select name="role" class="form-control" required>
                                                        <option value="">-- Select Role --</option>
                                                        <option value="admin"
                                                            {{ old('role') == 'admin' ? 'selected' : '' }}>
                                                            Admin
                                                        </option>
                                                        <option value="employee"
                                                            {{ old('role') == 'employee' ? 'selected' : '' }}>
                                                            Employee
                                                        </option>
                                                        <option value="customer"
                                                            {{ old('role') == 'customer' ? 'selected' : '' }}>
                                                            Customer
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group mb-3">
                                                    <label for="employee_id">Employee ID</label>
                                                    <input type="text" name="employee_id" class="form-control"
                                                        value="{{ old('employee_id') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">Username</span>
                                                    <input type="text" class="form-control" id="username"
                                                        name="username" value="{{ old('username') }}" required>
                                                </div>
                                                @error('username')
                                                    <p class="alert alert-danger">{{ $message }}</p>
                                                @enderror

                                            </div>
                                            <div class="col">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">Email</span>
                                                    <input type="email" class="form-control" id="email"
                                                        name="email">
                                                </div>
                                                @error('username')
                                                    <p class="alert alert-danger">{{ $message }}</p>
                                                @enderror

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">Password</span>
                                                    <input type="password" class="form-control" name="password" required>
                                                </div>
                                                @error('password')
                                                    <p class="alert alert-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="col">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">Confirm Password</span>
                                                    <input type="password" class="form-control" name="password_confirmation"
                                                        required>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">Name</span>
                                                    <input type="text" class="form-control" id="name" name="name"
                                                        value="{{ old('name') }}" required>
                                                </div>
                                                @error('username')
                                                    <p class="alert alert-danger">{{ $message }}</p>
                                                @enderror

                                            </div>
                                            <div class="col">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">Phone</span>
                                                    <input type="phone" class="form-control" id="phone"
                                                        name="phone">
                                                </div>
                                                @error('username')
                                                    <p class="alert alert-danger">{{ $message }}</p>
                                                @enderror

                                            </div>
                                        </div>

                                        <div class="form-group mt-3">
                                            <label for="address">Address</label>
                                            <textarea name="address" class="form-control" rows="3">{{ old('address') }}</textarea>
                                        </div>

                                        <div class="form-group mt-4">
                                            <button type="submit" class="btn btn-primary">Add User</button>
                                            <a href="{{ route('admin.user.index') }}"
                                                class="btn btn-secondary">Cancel</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endsection
