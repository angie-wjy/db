@extends('layouts.backoffice')
@section('title', 'Add Bundle')
@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Smile Gift Shop</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home"><a href="#"><i class="icon-home"></i></a></li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item"><a href="#">Bundles</a></li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item"><a href="#">Add Bundle +</a></li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Add Bundle</h4>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <p class="alert alert-success">{{ session('success') }}</p>
                        @endif
                        @if (session('error'))
                            <p class="alert alert-danger">{{ session('error') }}</p>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.product.bundle.create') }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="name" class="form-label">Bundle Name</label>
                                    <input type="text" name="name" id="name" class="form-control" required>
                                </div>
                                <div class="col">
                                    <label for="price" class="form-label">Bundle Price</label>
                                    <input type="number" name="price" id="price" class="form-control" required>
                                </div>
                            </div>

                            {{-- <div class="mb-3">
                                <label for="product_id" class="form-label">Main Product</label>
                                <select name="product_id" id="product_id" class="form-select" required>
                                    <option value="">-- Select Main Product --</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div> --}}

                            <div id="product-group">
                                <div class="row mb-3 product-item">
                                    <div class="col-md-6">
                                        <label class="form-label">Product</label>
                                        <select name="products[]" class="form-select" required>
                                            <option value="">-- Select Product --</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->name }} (Stock:
                                                    {{ $product->stock }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Quantity</label>
                                        <input type="number" name="quantities[]" class="form-control" min="1" required>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-danger remove-btn">Remove</button>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <button type="button" id="add-product" class="btn btn-secondary">+ Add Product</button>
                            </div>

                            <button type="submit" class="btn btn-primary">Create Bundle</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Handle dynamic product adding and removal
        const productGroup = document.getElementById('product-group');
        const addProductButton = document.getElementById('add-product');

        addProductButton.addEventListener('click', () => {
            const item = productGroup.querySelector('.product-item');
            const clone = item.cloneNode(true);

            // Reset input fields for the new product
            clone.querySelector('select').selectedIndex = 0;
            clone.querySelector('input').value = '';
            productGroup.appendChild(clone);
        });

        // Handle removal of product fields
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-btn')) {
                const items = document.querySelectorAll('.product-item');
                if (items.length > 1) { // Don't allow removing the last product
                    e.target.closest('.product-item').remove();
                }
            }
        });
    </script>
@endsection
