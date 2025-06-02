@extends('layouts.backoffice')

@section('title', 'New Orders')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <h3 class="fw-bold mb-3">Smile Gift Shop</h3>
        <ul class="breadcrumbs mb-3">
            <li class="nav-home">
                <a href="#"><i class="icon-home"></i></a>
            </li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">New Orders</a></li>
        </ul>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">New Orders</h4>
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
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->customers_id }}</td>
                                    <td>{{ \Carbon\Carbon::parse($order->date)->format('d-m-Y') }}</td>
                                    <td>Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                                    <td>
                                        @if($order->status == 'new')
                                            <span class="badge bg-primary">New</span>
                                        @elseif($order->status == 'processed')
                                            <span class="badge bg-warning text-dark">Processed</span>
                                        @elseif($order->status == 'completed')
                                            <span class="badge bg-success">Completed</span>
                                        @elseif($order->status == 'cancelled')
                                            <span class="badge bg-danger">Cancelled</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($order->is_paid)
                                            <span class="badge bg-success">Paid</span>
                                        @else
                                            <span class="badge bg-danger">Unpaid</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.order.show', $order->id) }}" class="btn btn-info btn-sm">Details</a>

                                        {{-- Button approve --}}
                                        <form action="{{ route('admin.order.approve', $order->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success btn-sm">Approve</button>
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
        $('#new-order-table').DataTable({
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ entri",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Berikutnya",
                    previous: "Sebelumnya"
                },
                zeroRecords: "Tidak ada data ditemukan",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
                infoFiltered: "(disaring dari _MAX_ total entri)"
            }
        });
    });
</script>
@endpush
