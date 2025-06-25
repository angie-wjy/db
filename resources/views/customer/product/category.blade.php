@extends('layouts.customer')
@section('title', 'Category ' . ($selectedCategory->name ?? 'Products'))
@section('content')

<div class="row mx-auto">
    <div class="col-2 ms-4 p-3 rounded border border-3" id="filter" style="background-color: #EEE9E7; max-height: 30rem;">
        {{-- FORM ACTION MUST POINT TO CURRENT ROUTE WITH SLUG --}}
        <form action="{{ route('category.show', ['slug' => $selectedCategory->slug]) }}" method="get">
            <div class="">
                <div id="category" class="mb-3">
                    <h4>Category</h4>
                    @foreach ($dataCat as $d)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="cat[]" value="{{$d->code}}"
                            {{-- Check if this category is in the 'cat[]' request --}}
                            {{ in_array($d->code, request()->query('cat', [])) ? 'checked' : '' }}
                            {{-- Additionally: if there's no 'cat' filter at all, check the category that matches the slug --}}
                            {{ (!request()->has('cat') && $selectedCategory->code === $d->code) ? 'checked' : '' }}
                        >
                        <label class="form-check-label">
                            {{$d->name}}
                        </label>
                    </div>
                    @endforeach
                </div>
                <div id="range" class="mb-3">
                    <h4>Price Range</h4>
                    {{-- Make sure min, max, and step values match your product price range --}}
                    {{-- Default value should come from request if exists, otherwise use max --}}
                    <input type="range" class="form-range" min="0" max="1000000" step="50000" name="price" id="priceRange" value="{{ request()->query('price', 1000000) }}">
                    <label for="priceRange" class="form-label">Up to: Rp<span id="priceValue">{{ number_format(request()->query('price', 1000000), 0, ',', '.') }}</span></label>
                </div>
                <div id="sort" class="mb-3">
                    <h4>Sort</h4>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sort" value="PRICE_UP" {{ request()->query('sort') === 'PRICE_UP' ? 'checked' : '' }}>
                        <label class="form-check-label">
                            Lowest Price
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sort" value="PRICE_DOWN" {{ request()->query('sort') === 'PRICE_DOWN' ? 'checked' : '' }}>
                        <label class="form-check-label">
                            Highest Price
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sort" value="DATE_UP" {{ request()->query('sort') === 'DATE_UP' ? 'checked' : '' }}>
                        <label class="form-check-label">
                            Newest Products
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-warning">Apply</button>
            </div>
        </form>
    </div>
    <div class="col-9 ms-1" id="content">
        <div class="row row-cols-1 row-cols-md-6 g-3">
            @if ($dataProd->isEmpty())
                <p class="text-center text-gray-600 w-full">No products found for this category.</p>
            @else
                @foreach ($dataProd as $d)
                <div class="col">
                    <a href="/product/detail/{{$d->id}}">
                        <div class="card">
                            <img src="{{asset('images/produk/'.$d->image)}}" class="card-img-top" alt="{{ $d->name }}" style="max-width:12rem;max-height: 11rem;">
                            <div class="card-body">
                                <h5 class="card-title">{{$d->name}}</h5>
                                <p class="card-text"><strong>Rp{{ number_format($d->price, 0, ',', '.') }}</strong></p>
                                <p class="card-text">{{ Str::limit($d->description, 50) }}</p>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            @endif
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{-- Make sure this uses the pagination view you prefer --}}
            {{ $dataProd->links() }}
        </div>
    </div>
</div>

<script>
    const priceRange = document.getElementById('priceRange');
    const priceValue = document.getElementById('priceValue');

    priceRange.addEventListener('input', () => {
        priceValue.textContent = parseInt(priceRange.value).toLocaleString('id-ID');
    });

    // Set initial value on page load
    window.onload = function() {
        priceValue.textContent = parseInt(priceRange.value).toLocaleString('id-ID');
    };
</script>

@endsection
