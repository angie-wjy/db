@extends('layouts.backoffice')

@section('title', 'Order Details')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <h4 class="fw-bold mb-3">Order Details</h4>
    </div>

    <div class="card">
        <div class="card-body">
            <h5><strong>Order ID:</strong> {{ $order->id }}</h5>
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($order->date)->format('d-m-Y') }}</p>
            <p><strong>Customer:</strong> {{ $order->customer->name }}</p>
            <p><strong>Phone:</strong> {{ $order->customer->phone }}</p>

            <hr>

            <h5 class="mb-3">Product Details:</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="bg-light">
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price (Rp)</th>
                            <th>Subtotal (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach ($order->orderDetails as $item)
                            @php $subtotal = $item->quantity * $item->price; @endphp
                            @php $total += $subtotal; @endphp
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->price, 0, ',', '.') }}</td>
                                <td>{{ number_format($subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="3" class="text-end"><strong>Total</strong></td>
                            <td><strong>Rp{{ number_format($total, 0, ',', '.') }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <a href="{{ route('admin.order.index') }}" class="btn btn-secondary mt-3">Back to Orders</a>
        </div>
    </div>
</div>
@endsection
