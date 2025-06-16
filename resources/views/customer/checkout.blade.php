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
                        <p><strong>Order Number:</strong> {{ $order->id }}</p>
                        <p><strong>Order Date:</strong> {{ $order->created_at->format('d M Y') }}</p>
                        <p><strong>Total Product Price:</strong> Rp{{ number_format($order->total, 0, ',', '.') }}</p>

                        <hr>
                        <p><strong>Product List:</strong></p>
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
                    <div class="card-header bg-secondary text-white">Shipment</div>
                    <div class="card-body">
                        <p><strong>Method:</strong> {{ $order->delivery->type ?? '-' }}</p>
                        {{-- <p><strong>Status:</strong> {{ $order->delivery->status ?? '-' }}</p> --}}
                        {{-- <p><strong>Tracking Number:</strong> {{ $order->delivery->resi ?? '-' }}</p> --}}

                        @if ($order->delivery->type === 'delivery')
                            <p><strong>Address:</strong> {{ $order->delivery->address ?? '-' }}</p>
                        @endif
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header bg-success text-white">Payment Summary</div>
                    <div class="card-body">
                        <p><strong>Total Payment:</strong> Rp{{ number_format($order->total, 0, ',', '.') }}</p>
                        {{-- Jika ada ongkir: Rp{{ number_format($order->total + $order->deliveryOption->price, 0, ',', '.') }} --}}
                    </div>
                </div>

                {{-- Tombol Pembayaran --}}
                <a class="btn btn-primary w-100" id="pay-button">Next to Payment</a>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function() {
            // SnapToken tersedia di variabel `snapToken` yang dilewatkan dari controller
            snap.pay('{{ $snapToken }}', {
                // onSuccess: function(result){
                //     /* You may add your own implementation here */
                //     alert("Pembayaran berhasil!"); console.log(result);
                // },
                onSuccess: function(result) {
                    fetch("{{ route('payment.callback') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify(result)
                        })
                        .then(response => response.json())
                        .then(data => {
                            alert("Pembayaran berhasil!");
                            window.location.href =
                            "{{ route('customer.checkout.success') }}"; // redirect ke halaman pesanan
                        })
                        .catch(error => {
                            console.error("Error saat update status:", error);
                            alert("Pembayaran berhasil, tapi gagal memperbarui status.");
                        });
                }

                onPending: function(result) {
                    /* You may add your own implementation here */
                    alert("Pembayaran tertunda!");
                    console.log(result);
                },
                onError: function(result) {
                    /* You may add your own implementation here */
                    alert("Pembayaran gagal!");
                    console.log(result);
                },
                onClose: function() {
                    /* You may add your own implementation here */
                    alert('Anda menutup popup tanpa menyelesaikan pembayaran');
                }
            });
        };
    </script>
@endsection
