@extends('layouts.backoffice')
@section('title', 'Approve Shipping')
@section('content')
    <style>
        .btn-custom {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 6px;
            font-weight: 500;
            border: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.2s ease;
            text-align: center;
            vertical-align: middle;
            line-height: 1.5;
            min-width: 120px;
            height: 38px;
            font-size: 1rem;
        }

        .btn-custom:hover {
            opacity: 0.9;
        }

        .btn-custom-success {
            background-color: #10b981;
            /* Emerald */
            color: #ffffff;
        }

        .btn-custom-danger {
            background-color: #ef4444;
            /* Red */
            color: #ffffff;
        }
    </style>

    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Approve Shipping</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home"><a href="#"><i class="icon-home"></i></a></li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item">
                    <a href="#">Orders</a>
                </li>
                <li class="separator">
                <li class="nav-item"><a href="#">Approve Shipping</a></li>
            </ul>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Orders Pending Shipping Approval</h4>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <p class="alert alert-success">{{ session('success') }}</p>
                    @endif
                    <div class="table-responsive">
                        <table id="multi-filter-select" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Customer</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Customer</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ \Carbon\Carbon::parse($order->date)->format('d-m-Y') }}</td>
                                        <td>Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                                        <td>{{ $order->customers_id }}</td>
                                        <td>
                                            <form action="{{ route('admin.order.approveShipping', $order->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn-custom btn-custom-success">
                                                    <i class="ri-check-line"></i> Approve
                                                </button>
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

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#multi-filter-select').DataTable();
        });
    </script>
@endpush
