@extends('layouts.backoffice')
@section('title', 'All Orders')
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

        .btn-custom-info {
            background-color: #3b82f6;
            color: #ffffff;
        }
    </style>

    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Smile Gift Shop</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="#"><i class="icon-home"></i></a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item"><a href="#">Orders</a></li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item"><a href="#">All Orders</a></li>
            </ul>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">All Orders</h4>
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
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Customer ID</th>
                                    {{-- <th>Employee ID</th> --}}
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Customer ID</th>
                                    {{-- <th>Employee ID</th> --}}
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ \Carbon\Carbon::parse($order->date)->format('d-m-Y') }}</td>
                                        <td>Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                                        <td>
                                            @if ($order->status == 'new')
                                                <span class="badge bg-primary">New</span>
                                            @elseif($order->status == 'processed')
                                                <span class="badge bg-warning text-dark">Processed</span>
                                            @elseif($order->status == 'completed')
                                                <span class="badge bg-success">Completed</span>
                                            @elseif($order->status == 'cancelled')
                                                <span class="badge bg-danger">Cancelled</span>
                                            @elseif($order->status == 'approved_shipping')
                                                <span class="badge bg-info">Approved Shipping</span>
                                            @else
                                                <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $order->customers_id }}</td>
                                        {{-- <td>{{ $order->employee_id }}</td> --}}
                                        <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y H:i') }}</td>
                                        <td>
                                            <button type="button" class="btn-custom btn-custom-info" data-bs-toggle="modal"
                                                data-bs-target="#orderDetailModal{{ $order->id }}">
                                                <i class="ri-eye-line"></i> View Details
                                            </button>
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

    {{-- Modal Section --}}
    @foreach ($orders as $o)
        {{-- <tr>
            <td>{{ $o->id }}</td>
            <td>{{ \Carbon\Carbon::parse($o->date)->format('d-m-Y') }}</td>
            <td>Rp{{ number_format($o->total, 0, ',', '.') }}</td>
            <td>
                @if ($o->status == 'new')
                    <span class="badge bg-primary">New</span>
                @elseif($o->status == 'processed')
                    <span class="badge bg-warning text-dark">Processed</span>
                @elseif($o->status == 'completed')
                    <span class="badge bg-success">Completed</span>
                @elseif($o->status == 'cancelled')
                    <span class="badge bg-danger">Cancelled</span>
                @else
                    <span class="badge bg-secondary">{{ ucfirst($o->status) }}</span>
                @endif
            </td>
            <td>{{ $o->customers_id }}</td>
            <td>{{ $o->employee_id }}</td>
            <td>{{ \Carbon\Carbon::parse($o->created_at)->format('d-m-Y H:i') }}</td>
            <td>
                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                    data-bs-target="#oDetailModal{{ $o->id }}">
                    View
                </button>
            </td>
        </tr> --}}

        {{-- Modal untuk order ini --}}
        <div class="modal fade" id="orderDetailModal{{ $o->id }}" tabindex="-1"
            aria-labelledby="orderDetailModalLabel{{ $o->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="orderDetailModalLabel{{ $o->id }}">
                            Order #{{ $o->id }} Details
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><b>Customer:</b> {{ $o->customer->name ?? '-' }}</p>
                        <p><b>Phone:</b> {{ $o->customer->phone ?? '-' }}</p>
                        <p><b>Order Date:</b> {{ \Carbon\Carbon::parse($o->date)->format('d-m-Y') }}</p>
                        <p><b>Order Number:</b> {{ $o->id }}</p>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($o->products as $p)
                                    <tr>
                                        <td>{{ $p->name }}</td>
                                        <td>{{ $p->pivot->quantity }}</td>
                                        <td>Rp{{ number_format($p->pivot->price, 0, ',', '.') }}</td>
                                        <td>Rp{{ number_format($p->pivot->price * $p->pivot->quantity, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <p><b>Total:</b> Rp{{ number_format($order->total, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#multi-filter-select').DataTable({
                "order": [
                    [0, "desc"]
                ],
                "columnDefs": [{
                    "targets": [7],
                    "orderable": false
                }]
            });
        });
    </script>
