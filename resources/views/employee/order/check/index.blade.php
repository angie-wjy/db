@extends('layouts.employee')
@section('title', 'Check Orders')
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

        .btn-custom-success {
            background-color: #10b981;
            color: #ffffff;
        }

        .btn-custom-warning {
            background-color: #f59e0b;
            color: #ffffff;
        }
    </style>

    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Check Orders</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="#"><i class="icon-home"></i></a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item"><a href="#">Check Orders</a></li>
            </ul>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Processed Orders - Check Stock</h4>
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
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Price</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Price</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->customer->name ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($order->date)->format('d-m-Y') }}</td>
                                        <td>Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y H:i') }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn-custom btn-custom-info" data-bs-toggle="modal"
                                                data-bs-target="#orderDetailModal{{ $order->id }}">
                                                <i class="ri-eye-line"></i> View Details
                                            </button>

                                            <form action="{{ route('admin.order.check.ready', $order->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn-custom btn-custom-success">
                                                    <i class="ri-check-line"></i> Confirm Ready
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.order.check.notready', $order->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn-custom btn-custom-warning">
                                                    <i class="ri-close-line"></i> Not Ready
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

    {{-- Modal Section --}}
    @foreach ($orders as $order)
        <div class="modal fade" id="orderDetailModal{{ $order->id }}" tabindex="-1"
            aria-labelledby="orderDetailModalLabel{{ $order->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="orderDetailModalLabel{{ $order->id }}">
                            Order #{{ $order->id }} Details
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><b>Customer:</b> {{ $order->customer->name ?? '-' }}</p>
                        <p><b>Phone:</b> {{ $order->customer->phone ?? '-' }}</p>
                        <p><b>Order Date:</b> {{ \Carbon\Carbon::parse($order->date)->format('d-m-Y') }}</p>
                        <p><b>Order Number:</b> {{ $order->id }}</p>

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
                                @foreach ($order->products as $product)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->pivot->quantity }}</td>
                                        <td>Rp{{ number_format($product->pivot->price, 0, ',', '.') }}</td>
                                        <td>Rp{{ number_format($product->pivot->price * $product->pivot->quantity, 0, ',', '.') }}
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
                pageLength: 10,
                initComplete: function() {
                    this.api().columns().every(function() {
                        var column = this;
                        var select = $(
                                '<select class="form-select form-select-sm"><option value=""></option></select>'
                            )
                            .appendTo($(column.footer()).empty())
                            .on('change', function() {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                column.search(val ? '^' + val + '$' : '', true, false)
                                    .draw();
                            });

                        column.data().unique().sort().each(function(d, j) {
                            select.append('<option value="' + d + '">' + d +
                                '</option>')
                        });
                    });
                }
            });
        });
    </script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
@endpush
