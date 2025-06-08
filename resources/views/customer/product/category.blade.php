@extends('customer.template_import')
@section('title')
@section('content')

<div class="row mx-auto" >
    <div class="col-2 ms-4 p-3 rounded border border-3" id="filter" style="background-color: #EEE9E7; max-height: 30rem;">
        <form action="/product/category" method="get">
            <div class="">
                <div id="category" class="mb-3">
                    <h4>Category</h4>
                    @foreach ($dataCat as $d)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="cat[]" value="{{$d->code}}" {{ in_array($d->code, request()->query('cat', [])) ? 'checked' : '' }} >
                        <label class="form-check-label">
                          {{$d->name}}
                        </label>
                      </div>
                    @endforeach
                </div>
                <div id="range" class="mb-3">
                    <h4>Price Range</h4>
                    <input type="range" class="form-range" min="0" max="1000" step="50" name="price" id="priceRange">
                    <label for="priceRange" class="form-label">Up to: $<span id="priceValue">1000</span></label>
                </div>
                <div id="sort" class="mb-3">
                    <h4>Sort</h4>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sort" value="PRICE_UP">
                        <label class="form-check-label">
                          Harga Terendah
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sort" value="PRICE_DOWN">
                        <label class="form-check-label">
                          Harga Tertinggi
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sort" value="DATE_UP">
                        <label class="form-check-label">
                          Produk Terbaru
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-warning">Apply</button>
            </div>
        </form>
    </div>
    <div class="col-9 ms-1" id="content" >
        <div class="row row-cols-1 row-cols-md-6 g-3">
            @foreach ($dataProd as $d)
            <div class="col">
                <a href="/product/detail/{{$d->id}}">
                    <div class="card">
                      <img src="{{asset('images/produk/'.$d->image)}}" class="card-img-top" alt="err" style="max-width:12rem;max-height: 11rem;">
                      <div class="card-body">
                        <h5 class="card-title"> {{$d->name}}</h5>
                        <p class="card-text"><strong>{{$d->price}}</strong> </p>
                        <p class="card-text">{{$d->description}}</p>
                      </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
