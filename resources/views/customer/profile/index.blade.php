@extends('layouts.customer')

@section('title', 'My Profile - ' . $customer->name)

@section('content')
    <div
        class="container mx-auto max-w-6xl bg-white rounded-2xl shadow-xl overflow-hidden transform transition-all duration-300 ease-in-out py-6 px-4 sm:px-8">

        <header class="section_container mb-8 mt-2 w-full">
            <div class="header_content text-center max-w-2xl mx-auto break-words">
                <h4 class="uppercase text-indigo-600 tracking-wide font-semibold text-sm mb-1">WELCOME BACK</h4><br>
                <h1 class="text-3xl font-bold text-gray-900 mb-1">Hello, {{ $customer->name }}</h1><br>
                <p class="text-gray-600">{{ $customer->email }}</p>
                <p class="text-gray-500 text-xs italic mb-3">Joined since: {{ $customer->created_at->format('d M Y') }}</p>
                <p class="text-gray-600 leading-relaxed text-base">
                    Manage your profile and review your order history here. We're happy to have you back!
                </p>
            </div>
        </header>


        {{-- Order History --}}
        <div class="mt-12 pt-8 border-t border-gray-200">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">My Order History</h2>

            @if ($orders->isEmpty())
                <div class="p-6 text-center bg-gray-50 rounded-xl shadow-inner">
                    <p class="text-gray-600 text-lg">You don't have any order history yet.</p>
                    <a href="/"
                        class="btn-gradient inline-block mt-6 py-2.5 px-5 rounded-lg text-base font-semibold text-white shadow-md hover:shadow-lg transition">Start
                        Shopping</a>
                </div>
            @else
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    @foreach ($orders as $order)
                        <div class="col">
                            <div class="card h-100 p-4 shadow-sm rounded-lg">
                                <div class="mb-3">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <h5 class="fw-semibold mb-0">Order #{{ $order->id }}</h5>
                                        @php
                                            $shipStatus = $order->ship->status ?? 'N/A';
                                            $statusClass = match ($shipStatus) {
                                                'on progress' => 'status-on-progress',
                                                'ready' => 'status-ready',
                                                'finish' => 'status-finish',
                                                default => 'status-cancelled',
                                            };
                                        @endphp
                                        <span class="status-badge {{ $statusClass }}">
                                            {{ ucwords(str_replace('_', ' ', $shipStatus)) }}
                                        </span>
                                    </div>
                                    <p class="text-muted small mb-1">Order Date:
                                        {{ $order->created_at->format('d M Y, H:i') }}</p>
                                    <p class="fw-bold mb-1 text-dark">Total:
                                        Rp{{ number_format($order->total ?? 0, 0, ',', '.') }}</p>
                                    @if ($order->ship?->resi)
                                        <p class="text-muted small mb-1">Tracking Number: <span
                                                class="fw-semibold text-primary">{{ $order->ship->resi }}</span></p>
                                    @endif
                                    @if ($order->ship?->address)
                                        <p class="text-muted small">Shipping Address: {{ $order->ship->address }}
                                        </p>
                                    @endif
                                </div>
                                <a href="{{ route('customer.order.show', $order->id) }}" class="btn btn-primary w-100">View
                                    Details</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Back Button --}}
        <div class="bg-gray-50 px-8 py-6 sm:px-10 sm:py-8 border-t border-gray-200 mt-12">
            <div class="text-center">
                <a href="/"
                    class="text-indigo-700 hover:text-indigo-900 text-base sm:text-lg font-medium flex items-center justify-center hover:scale-105 transition">
                    <i class="ri-arrow-left-line mr-2"></i> Back to Homepage
                </a>
                <br><br><br><br>
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
