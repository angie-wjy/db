@extends('layouts.customer')
@section('title', 'Detail Product')
@section('content')
    <div class="content">
        <br><br>
        <div class="card mb-3 mx-auto p-5"
            style="max-width: 1000px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 10px;">
            <div class="row g-0">
                <div class="col-md-6">
                    <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded-start shadow-sm"
                        alt="..." style="border-radius: 10px; object-fit: cover; height: 400px;">
                </div>
                <div class="col-md-6">
                    <div class="card-body">
                        <h5 class="card-title" style="font-size: 2.5rem; font-weight: bold; color: #333;">
                            {{ $product->name }}
                        </h5>
                        <p class="card-text" style="font-weight: bold; font-size: 2rem; color: #e60012;">
                            Rp.{{ number_format($product->price, 0, 0, '.') }}</p>

                        {{-- select branch --}}
                        <div class="mb-3">
                            <label for="branchSelect" class="form-label" style="font-size: 1.2rem; color: #555;">
                                Branch</label>
                            <select class="form-select" id="branchSelect" name="branch_id"
                                style="border-radius: 5px; font-size: 1.1rem;" onchange="updateStockInfo()">
                                @foreach ($product->branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->mall }}</option>
                                @endforeach
                            </select>
                        </div>

                        <p class="card-text" style="font-size: 1.2rem; color: #555; margin-top: 20px;" id="stockInfo">Stock : {{ isset($product->branches[0]->pivot->stock) ? $product->branches[0]->pivot->stock : 0 }}</p>
                        {{-- <p class="card-text" style="font-size: 1.2rem; color: #555; margin-top: 20px;">
                            Stock : {{ isset($product->stock) ? $product->stock : 0 }}
                        </p> --}}

                        <p class="card-text" style="font-size: 1.2rem; color: #555; margin-top: 20px; margin-bottom: 5px;">
                            Description</p>
                        <ul style="font-size: 1.1rem; color: #666; margin-left: 20px;">
                            @foreach (explode("\n", $product->description) as $point)
                                @if (trim($point) != '')
                                    <li style="margin-bottom: 5px;">{{ ltrim(trim($point), '- ') }}</li>
                                @endif
                            @endforeach
                        </ul>

                        <form action="{{ route('customer.product.add', $product->id) }}" method="post" class="mt-4">
                            @csrf
                            <div class="input-group">
                                <span class="input-group-text"
                                    style="background-color: #f8f9fa; font-weight: bold;">Jumlah</span>
                                <input type="number" min="1" value="1" name="jumlah" class="form-control"
                                    style="max-width: 6rem; border-radius: 5px;">
                                <button type="submit" class="btn btn-warning"
                                    style="border-radius: 5px; font-weight: bold; padding-left: 20px; padding-right: 20px;">
                                    <i class="ri-shopping-cart-line">Add to cart</i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
    function updateStockInfo() {
        const branchSelect = document.getElementById('branchSelect');
        const stockInfo = document.getElementById('stockInfo');
        const selectedBranchId = branchSelect.value;

        // Find the selected branch's stock
        const selectedBranch = @json($product->branches).find(branch => branch.id == selectedBranchId);
        const stock = selectedBranch ? selectedBranch.pivot.stock : 0;

        // Update the stock information
        stockInfo.textContent = `Stock : ${stock}`;
    }
</script>
@endsection
