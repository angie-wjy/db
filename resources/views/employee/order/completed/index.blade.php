@extends('layouts.backoffice')
@section('title', 'Completed Orders')
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
            color: #ffffff;
        }
    </style>

    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Completed Orders</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home"><a href="#"><i class="icon-home"></i></a></li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item"><a href="#">Orders</a></li>
                <li class="separator"></li>
                <li class="nav-item"><a href="#">Completed Orders</a></li>
            </ul>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">List of Completed Orders (Approved Shipping)</h4>
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
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Created At</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->customer->name ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($order->date)->format('d-m-Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y H:i') }}</td>
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
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
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
                                column
                                    .search(val ? '^' + val + '$' : '', true, false)
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
@endpush
