@extends('layouts.customer')
@section('title', 'Payment')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Payment</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('customer.payment', $order->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="payment_proof" class="form-label">Payment (gambar)</label>
            <input type="file" class="form-control" name="payment_proof" required>
        </div>
        <button type="submit" class="btn btn-success">Send Payment</button>
    </form>
</div>
@endsection
