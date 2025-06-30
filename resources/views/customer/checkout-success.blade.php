@extends('layouts.customer')
@section('title', 'Checkout Sukses')

@section('content')
    <div class="container py-5">
        <h3 class="text-center text-success">Payment Successful!</h3>
        <p class="text-center">Thank you! Your order is being processed.</p>
        <div class="text-center">
            <a href="{{ route('customer.order.show', $order->id) }}" class="btn btn-primary mt-3">
                View Order Details
            </a>

        </div>
    </div>
@endsection
