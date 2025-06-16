@extends('layouts.customer')
@section('title', 'Checkout')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4">Checkout</h2>

        <div class="row">
            <!-- Kolom Kiri: Detail Order -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">Detail Order</div>
                    <div class="card-body">
                        <p><strong>Nomor Order:</strong> {{ $order->id }}</p>
                        <p><strong>Tanggal Order:</strong> {{ $order->created_at->format('d M Y') }}</p>
                        <p><strong>Total Harga Produk:</strong> Rp{{ number_format($order->total, 0, ',', '.') }}</p>

                        <hr>
                        <p><strong>Daftar Produk:</strong></p>
                        <ul class="list-group list-group-flush">
                            @foreach ($order->products as $product)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        {{ $product->name }} <br>
                                        <small>Qty: {{ $product->pivot->quantity }}</small>
                                    </div>
                                    <span class="text-end">Rp{{ number_format($product->pivot->price, 0, ',', '.') }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Info Pengiriman + Ringkasan -->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header bg-secondary text-white">Pengiriman</div>
                    <div class="card-body">
                        <p><strong>Metode:</strong> {{ $order->delivery->type ?? '-' }}</p>
                        <p><strong>Status:</strong> {{ $order->delivery->status ?? '-' }}</p>
                        <p><strong>Nomor Resi:</strong> {{ $order->delivery->resi ?? '-' }}</p>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header bg-success text-white">Ringkasan Pembayaran</div>
                    <div class="card-body">
                        <p><strong>Total Pembayaran:</strong> Rp{{ number_format($order->total, 0, ',', '.') }}</p>
                        {{-- Jika ada ongkir: Rp{{ number_format($order->total + $order->deliveryOption->price, 0, ',', '.') }} --}}
                    </div>
                </div>

                {{-- Tombol Pembayaran --}}
                {{-- <a href="{{ route('payment.page', $order->id) }}" class="btn btn-primary w-100">Lanjut ke Pembayaran</a> --}}
            </div>
        </div>
    </div>
@endsection
