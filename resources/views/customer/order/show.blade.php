@extends('layouts.customer')

@section('title', 'Order #' . $order->id . ' - Details')

@section('content')
    <div
        class="container mx-auto max-w-6xl bg-white rounded-2xl shadow-xl overflow-hidden transform transition-all duration-300 ease-in-out py-6 px-4 sm:px-8">

        {{-- Order Details Header --}}
        <header class="section_container mb-8 mt-2 w-full">
            <div class="header_content text-center max-w-2xl mx-auto">
                <h4 class="uppercase text-indigo-600 tracking-wide font-semibold text-xs sm:text-sm mb-1">ORDER DETAILS</h4><br>
                <h1 class="text-3xl font-bold text-gray-900 mb-1">Order #{{ $order->id }}</h1><br>
                <p class="text-gray-600 text-sm sm:text-base mb-2">Placed on: {{ $order->created_at->format('d M Y, H:i') }}
                </p>
                @php
                    $shipStatus = $order->ship->status ?? 'N/A';
                    $statusClass = match ($shipStatus) {
                        'on progress' => 'status-on-progress',
                        'ready' => 'status-ready',
                        'finish' => 'status-finish',
                        default => 'status-cancelled',
                    };
                @endphp
                <span class="status-badge {{ $statusClass }} inline-block mb-4">
                    {{ ucwords(str_replace('_', ' ', $shipStatus)) }}
                </span>
                <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
                    Here are the details for your order. Thank you for your purchase!
                </p>
            </div>
        </header>

        <div class="row">
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header bg-white border-bottom-0">
                        <h3 class="text-1xl sm:text-2xl font-bold text-gray-900 mb-0 text-center">Order Summary</h3>
                    </div>
                    <div class="card-body">
                        <div class="space-y-3">
                            <div class="flex justify-between items-center text-gray-700">
                                <span>Order ID:</span>
                                <span class="font-semibold">#{{ $order->id }}</span>
                            </div>
                            <div class="flex justify-between items-center text-gray-700">
                                <span>Order Date:</span>
                                <span class="font-semibold">{{ $order->created_at->format('d M Y, H:i') }}</span>
                            </div>
                            <div class="flex justify-between items-center text-gray-700">
                                <span>Payment Method:</span>
                                <span class="font-semibold">{{ $order->payment_method ?? 'N/A' }}</span>
                            </div>
                            <div
                                class="flex justify-between items-center text-gray-700 font-bold text-lg border-t pt-3 mt-3 border-gray-200">
                                <span>Total Amount:</span>
                                <span class="text-indigo-700">Rp{{ number_format($order->total ?? 0, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header bg-white border-bottom-0">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Products in this Order</h2>
                    </div>
                    @if ($order->orderDetails->isEmpty())
                        <div class="p-6 text-center bg-gray-50 rounded-xl shadow-inner">
                            <p class="text-gray-600 text-lg">No products found for this order.</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach ($order->orderDetails as $detail)
                                <div class="flex items-center bg-gray-50 p-4 rounded-lg shadow-sm">
                                    <div class="flex-shrink-0 w-20 h-20 bg-gray-200 rounded-md overflow-hidden mr-4">
                                        @if ($detail->product->image)
                                            <img src="{{ asset('storage/' . $detail->product->image) }}"
                                                alt="{{ $detail->product->name }}" class="w-50 h-30 object-cover">
                                        @else
                                            <div
                                                class="w-full h-full flex items-center justify-center text-gray-400 text-xs">
                                                No Image</div>
                                        @endif
                                    </div>
                                    <div class="flex-grow">
                                        <h4 class="font-semibold text-gray-900">{{ $detail->product->name }}</h4>
                                        <p class="text-gray-600 text-sm">Quantity: {{ $detail->quantity }}</p>
                                        <p class="text-gray-800 font-medium">
                                            Rp{{ number_format($detail->price ?? 0, 0, ',', '.') }} each</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-gray-900 font-bold">Total Item:
                                            Rp{{ number_format($detail->quantity * ($detail->price ?? 0), 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header bg-white border-bottom-0">
                        <h3 class="text-1xl sm:text-2xl font-bold text-gray-900 mb-0 text-center">Shipping Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="flex justify-between items-center text-gray-700">
                            <span>Shipping Status:</span>
                            <span class="status-badge {{ $statusClass }}">
                                {{ ucwords(str_replace('_', ' ', $shipStatus)) }}
                            </span>
                        </div>
                        @if ($order->ship?->resi)
                            <div class="flex justify-between items-center text-gray-700">
                                <span>Tracking Number:</span>
                                <span class="font-semibold text-primary">{{ $order->ship->resi }}</span>
                            </div>
                        @else
                            <div class="text-gray-500 italic text-sm">Tracking number not available yet.</div>
                        @endif
                        <div class="text-gray-700">
                            <span class="block mb-1 font-semibold">Shipping Address:</span>
                            <p class="text-sm leading-relaxed">{{ $order->ship->address ?? 'N/A' }}</p>
                            <p class="text-sm leading-relaxed">{{ $order->ship->city ?? '' }},
                                {{ $order->ship->postal_code ?? '' }}</p>
                            {{-- Add more address fields if available in your ship model --}}
                        </div>
                        <div class="text-gray-700">
                            <span class="block mb-1 font-semibold">Recipient Name:</span>
                            <p class="text-sm leading-relaxed">{{ $order->ship->recipient_name ?? 'N/A' }}</p>
                        </div>
                        <div class="text-gray-700">
                            <span class="block mb-1 font-semibold">Recipient Phone:</span>
                            <p class="text-sm leading-relaxed">{{ $order->ship->recipient_phone ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header bg-white border-bottom-0">
                        <h3 class="text-1xl sm:text-2xl font-bold text-gray-900 mb-0 text-center">Payment Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="flex justify-between items-center text-gray-700">
                            <span>Payment Method:</span>
                            <span class="font-semibold">{{ $order->payment_method ?? 'N/A' }}</span>
                        </div>
                        @if ($order->payment_status)
                            <div class="flex justify-between items-center text-gray-700">
                                <span>Payment Status:</span>
                                <span class="font-semibold">{{ $order->payment_status }}</span>
                            </div>
                        @else
                            <div class="text-gray-500 italic text-sm">Payment status not available.</div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Back Button --}}
            <div class="bg-gray-50 px-8 py-6 sm:px-10 sm:py-8 border-t border-gray-200 mt-12">
                <div class="text-center">
                    <a href="{{ route('customer.profile.index') }}"
                        class="text-indigo-700 hover:text-indigo-900 text-base sm:text-lg font-medium flex items-center justify-center hover:scale-105 transition">
                        <i class="ri-arrow-left-line mr-2"></i> Back to My Profile
                    </a><br><br><br><br>
                </div>
            </div>
        </div>

        <style>
            .btn-gradient {
                background-image: linear-gradient(to right, #6366f1, #8b5cf6);
            }

            .btn-gradient:hover {
                background-image: linear-gradient(to right, #4f46e5, #7c3aed);
            }

            .card {
                background-color: #ffffff;
                border-radius: 0.75rem;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            }

            .status-badge {
                padding: 0.25rem 0.75rem;
                border-radius: 9999px;
                font-size: 0.7rem;
                font-weight: 600;
                text-transform: uppercase;
            }

            .status-on-progress {
                background-color: #ffedd5;
                color: #b45309;
            }

            .status-ready {
                background-color: #dbeafe;
                color: #1e40af;
            }

            .status-finish {
                background-color: #d1fae5;
                color: #065f46;
            }

            .status-cancelled {
                background-color: #fee2e2;
                color: #991b1b;
            }
        </style>
    @endsection
