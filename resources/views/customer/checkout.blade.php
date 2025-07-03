@extends('layouts.customer')
@section('title', 'Checkout')
@section('content')
    <div class="container py-4">
        <header class="section_container mb-8 mt-2 w-full">
            <div class="header_content text-center max-w-2xl mx-auto">
                <h4 class="uppercase text-indigo-600 tracking-wide font-semibold text-xs sm:text-sm mb-5">
                    CHECKOUT
                </h4>
                <h1 class="text-xl sm:text-5xl font-bold text-gray-900 mb-3">
                    Complete Your Order
                </h1>
                <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
                    Review your order details and proceed to payment.
                </p>
            </div>
        </header>

        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header bg-white border-bottom-0">
                        <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-0">Detail Order</h3>
                    </div>

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

            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header bg-white border-bottom-0">
                        <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-0">Shipment</h3>
                    </div>

                    <div class="card-body">
                        <p><strong>Method:</strong> {{ $order->ship->type ?? '-' }}</p>
                        @if ($order->ship?->type === 'delivery')
                            <p><strong>Address:</strong> {{ $order->ship->address ?? '-' }}</p>
                        @endif
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header bg-white border-bottom-0">
                        <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-0">Payment</h3>
                    </div>

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
            // SnapToken is available in the `snapToken` variable passed from the controller
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    alert("Payment successful!");
                    window.location.href =
                        "{{ route('customer.checkout.success', $order->id) }}";
                },
                onPending: function(result) {
                    alert("Payment is pending!");
                    console.log(result);
                },
                onError: function(result) {
                    alert("Payment failed!");
                    console.log(result);
                },
                onClose: function() {
                    alert('You closed the popup without completing the payment');
                }
            });
        };
    </script>

@endsection
