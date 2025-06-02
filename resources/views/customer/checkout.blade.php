@extends('layouts.customer')
@section('title', 'Checkout')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4">Checkout</h2>

        <!-- Detail Order -->
        <div class="card mb-4">
            <div class="card-header">Detail Order</div>
            <div class="card-body">
                <p><strong>Nomor Order:</strong> {{ $order->id }}</p>
                <p><strong>Tanggal Order:</strong> {{ $order->created_at->format('d M Y') }}</p>
                <p><strong>Total Harga Produk:</strong> Rp{{ number_format($order->total_price, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Informasi Pengiriman -->
        <div class="card mb-4">
            <div class="card-header">Pengiriman</div>
            <div class="card-body">
                <p><strong>Metode Pengiriman:</strong> {{ $order->delivery->type ?? '-' }}</p>
                <p><strong>Status Pengiriman:</strong> {{ $order->delivery->status ?? '-' }}</p>
                <p><strong>Nomor Resi:</strong> {{ $order->delivery->resi ?? '-' }}</p>

            </div>
        </div>

        <!-- Total Keseluruhan -->
        <div class="card mb-4">
            <div class="card-header">Ringkasan Pembayaran</div>
            <div class="card-body">
                <p><strong>Total Pembayaran:</strong>
                    {{-- Rp{{ number_format($order->total_price + $order->deliveryOption->price, 0, ',', '.') }} --}}
                </p>
            </div>
        </div>

        <!-- Tombol lanjut pembayaran -->
        {{-- <a href="{{ route('payment.page', $order->id) }}" class="btn btn-primary">Lanjut ke Pembayaran</a> --}}
    </div>
@endsection
