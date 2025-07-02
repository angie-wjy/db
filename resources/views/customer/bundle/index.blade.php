@extends('layouts.customer')
@section('title', 'Bundle Deals')
@section('content')
    <div class="container py-5">
        <h2 class="mb-4 text-center fw-bold">Our Bundle Promotions</h2>

        @forelse ($bundles as $bundle)
            <section class="section_container deals_container mb-5">
                <div class="deals_image_group d-flex flex-wrap gap-2 mb-3">
                    @foreach ($bundle->products as $product)
                        <div class="deals_image" style="width: 100px; height: 100px; overflow: hidden;">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    @endforeach
                </div>

                <div class="deals_content">
                    <h5 style="color: #f97316;">Special Bundle Offer!</h5>
                    <h4 style="font-size: 1.5rem;">{{ $bundle->name }}</h4>

                    <ul>
                        @foreach ($bundle->products as $product)
                            <li>🧸 {{ $product->name }} ({{ $product->pivot->quantity }} pcs)</li>
                        @endforeach
                    </ul>

                    <p class="mb-2">Bundle Price: <strong>Rp{{ number_format($bundle->price, 0, ',', '.') }}</strong></p>

                    <form action="{{ route('customer.bundle.buy', $bundle->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">Buy This Bundle</button>
                    </form>
                </div>
            </section>
        @empty
            <p>No bundle deals available at the moment.</p>
        @endforelse
    </div>
@endsection
