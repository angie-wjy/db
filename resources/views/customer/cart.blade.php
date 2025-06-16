@extends('layouts.customer')
@section('title', 'Cart')
@section('content')
    <style>
        .object-fit-cover {
            object-fit: cover;
        }

        .cart_item_wrapper {
            width: 120%;
            margin: 1.5rem auto 0 auto;
            left: -10%;
            position: relative;
            padding-top: 1.5rem;
            border-radius: 1rem;
            background-color: rgb(252, 249, 249);
        }

        .cart_row_wrapper {
            display: flex;
            justify-content: flex-start;
            align-items: flex-start;
            margin-bottom: 1.5rem;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .custom-cart-checkbox {
            height: 1.8rem;
            width: 1.8rem;
            margin-right: 0.5rem;
            margin-top: 1rem;
            align-self: flex-start;
            accent-color: #fdd835;
        }

        .cart-card {
            /* max-width: 45rem; */
            width: 100%;
            margin-left: 0 auto;
            left: -10%;
            border-radius: 1rem;
        }

        .cart-image-container {
            max-width: 10rem;
            max-height: 10rem;
            overflow: hidden;
        }

        .cart-image {
            height: 100%;
            width: 100%;
            object-fit: cover;
            display: block;
            border-top-left-radius: 0.25rem;
            border-bottom-left-radius: 0.25rem;
        }

        .cart-details {
            padding-left: 1rem;
        }

        .cart-header {
            gap: 1rem;
        }

        .product-info .card-title {
            margin-bottom: 0.3rem;
        }

        .price {
            color: #d9534f;
        }

        .cart-actions form {
            margin: 0 0.25rem;
        }

        .cart-actions .btn {
            padding: 0.3rem 0.5rem;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cart-actions .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .cart-actions .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .cart-actions .btn-warning {
            background-color: #fbf404;
            border-color: #fbf404;
            color: #212529;
        }

        .cart-actions .btn i {
            pointer-events: none;
        }

        .checkout-box {
            background-color: #fff;
            padding: 1.5rem;
            border-radius: 1rem;
            max-height: 50rem;
            overflow-y: auto;
            margin-left: 1rem;
            margin-bottom: 2rem;
            padding-right: -5%;
        }

        .checkout-title {
            color: #000;
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .checkout-item {
            color: #fbf404;
            font-size: 1.2rem;
            margin-bottom: 0.8rem;
        }
    </style>
    <div class="content">
        @php
            $cart = session('cart') ?? [];
        @endphp

        @if (empty($cart))
            <h1 style="text-align: center">
                Masih belum ada item nih, yuk tambahkan
            </h1>
        @else
            <div class="cart_item_wrapper">
                <div class="container mt-4">
                    <div class="d-flex justify-content-between align-items-start flex-wrap">
                        {{-- Bagian Keranjang / Cart Items --}}
                        <div class="col-lg-8">
                            @foreach ($cart as $id => $d)
                                <div class="cart_row_wrapper mb-3">
                                    {{-- <input type="checkbox" class="custom-cart-checkbox" name="cbox" value="{{ $id }}"> --}}
                                    <div class="card cart-card">
                                        <div class="row g-0">
                                            <div class="col-md-4 cart-image-container">
                                                <img src="{{ Storage::url($d['image']) }}" class="img-fluid cart-image"
                                                    alt="...">
                                            </div>
                                            <div class="col-md-8 d-flex align-items-center">
                                                <div class="card-body cart-details w-100">
                                                    <div class="d-flex justify-content-between cart-header">
                                                        <div>
                                                            <h4 class="card-title mb-2">
                                                                <strong>{{ $d['name'] }}</strong>
                                                            </h4>
                                                            <h5 class="card-title price">Rp.
                                                                <strong>{{ number_format($d['price'], 0, 0, '.') }}</strong>
                                                            </h5>
                                                        </div>
                                                        <div class="d-flex align-items-center cart-actions">
                                                            <form
                                                                action="{{ route('cart.remove', ['product_id' => $d['id']]) }}"
                                                                method="POST" class="me-2">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">
                                                                    <i class="ri-delete-bin-6-line"></i>
                                                                </button>
                                                            </form>
                                                            <form action="/cart/minus/{{ $d['id'] }}" method="post"
                                                                class="me-1">
                                                                @csrf
                                                                <button type="submit" class="btn btn-secondary">
                                                                    <i class="ri-subtract-fill"></i>
                                                                </button>
                                                            </form>
                                                            <span class="mx-2 fw-bold">{{ $d['quantity'] }}</span>
                                                            <form action="/cart/plus/{{ $d['id'] }}" method="post">
                                                                @csrf
                                                                <button type="submit" class="btn btn-warning">
                                                                    <i class="ri-add-line"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="checkout-box" id="total">
                            @php
                                $totalHarga = 0;
                                foreach ($cart as $id => $d) {
                                    $totalHarga += $d['price'] * $d['quantity'];
                                }
                            @endphp

                            <h4>
                                <span style="color: black;">Total:</span>
                                <strong style="color: #fbf404;">Rp. {{ number_format($totalHarga, 0, ',', '.') }}</strong>
                            </h4>

                            <!-- Tombol untuk opsi metode pengiriman -->
                            <button id="optionDelivery" class="btn btn-warning mt-3">Check Out</button>

                            <!-- Form pilihan metode pengiriman, awalnya disembunyikan -->
                            <div id="deliveryForm"
                                style="display: none; margin-top: 1rem; background: #fff; padding: 1rem; border-radius: 0.5rem; box-shadow: 0 0 8px rgba(0,0,0,0.2);">
                                <h5><strong>Option Shipment</strong></h5>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="delivery_method" id="pickup"
                                        value="pickup" required>
                                    <label class="form-check-label" for="pickup">Pick Up</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="delivery_method" id="delivery"
                                        value="delivery" required>
                                    <label class="form-check-label" for="delivery">Delivery</label>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3" disabled id="selectBtn">Select</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- pickup modal --}}
            <div class="modal fade" id="pickupModal" tabindex="-1" aria-labelledby="pickupModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="pickupModalLabel">Branch</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <form action="{{ route('customer.checkout') }}" method="POST" id="pickupMethodForm">
                            @csrf
                            <input type="hidden" name="delivery_method" value="pick up">
                            <div class="modal-body">
                                <p class="text-center">Pick Up</p>
                                <select name="branch_id" id="branches" class="form-control">
                                    @foreach ($branches as $b)
                                        <option value="{{ $b->id }}">{{ $b->mall }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" id="pickup">Pick Up</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- delivery modal --}}
            <div class="modal fade" id="deliveryModal" tabindex="-1" aria-labelledby="deliveryModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <form action="{{ route('customer.checkout') }}" method="POST" id="deliveryMethodForm">
                        @csrf
                        <input type="hidden" name="delivery_method" value="delivery">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deliveryModalLabel">Delivery</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-center">Delivery</p>
                                {{-- select address --}}
                                <select name="address" id="selected_address" class="form-control">
                                </select>
                                {{-- button add new address --}}
                                <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal"
                                    data-bs-target="#addAddressModal">Add New Address</button>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" id="delivery">Delivery</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- new address modal --}}
            <div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addAddressModalLabel">Add New Address</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="addressForm">
                                @csrf
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        @endif
        {{-- input hidden csrf --}}
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        $(function() {
            var data = @json($dataCart);
            var dataToShow = [];
            var totalharga = 0;

            $('input[name="cbox"]').on('change', function() {
                if ($(this).prop('checked')) {
                    var val = $(this).val();
                    var filtered = data.filter(function(d) {
                        return d.id == val;
                    });
                    totalharga += filtered[0]['jumlah'] * filtered[0]['price'];
                    dataToShow.push(filtered[0]);
                } else {
                    var val = $(this).val();
                    var idx = dataToShow.findIndex(d => d.id == val);
                    totalharga -= dataToShow[idx]['jumlah'] * dataToShow[idx]['price'];
                    dataToShow.splice(idx, 1);
                }

                if (dataToShow.length != 0) {
                    $('#item_detail').empty();
                    $('#item_detail').append("<p> Detail item :</p> ")
                    $.each(dataToShow, function(idx, d) {
                        var tot = d.jumlah * d.price;
                        $('#item_detail').append("<p style='font-size: 0.9rem;'><strong> -> " + d
                            .name + "</strong>,  <strong>" + d.price.toString().replace(
                                /\B(?=(\d{3})+(?!\d))/g, ",") + "</strong> X <strong> " + d
                            .jumlah + " Pcs  = " + tot.toString().replace(
                                /\B(?=(\d{3})+(?!\d))/g, ",") + "</strong></p>")
                    });
                    $('#item_detail').append(
                        "<h5 class='ps-3 position-absolute bottom-0 start-0' >Harga total : Rp. <strong>" +
                        totalharga.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "</strong> </h5> "
                    )
                    $('#item_detail').append(
                        " <button type='submit' class='btn btn-warning position-absolute bottom-0 end-0'> Lanjut ke Checkout </button>"
                    )
                } else {
                    $('#item_detail').empty();
                }
            });
        })

        $(document).ready(function() {
            var data_branches = @json($branches);
            var div_branches = $("#branches");

            function pickup() {
                div_branches.empty();
                if ('   ' in navigator) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var user_location = L.latLng(position.coords.latitude, position.coords.longitude);

                        console.log("data_branches", data_branches);
                        for (const key in data_branches) {
                            const branch = data_branches[key];
                            var branch_location = L.latLng(branch.latitude, branch.longitude);

                            var distance = user_location.distanceTo(branch_location);
                            distance = (distance / 1000).toFixed(2) + ' km';

                            div_branches.append("<option value='" + branch.id + "'>" + branch.mall + " (" +
                                distance + ") </option>");
                        }
                    }, function(error) {
                        console.log('Tidak dapat memperoleh lokasi Anda: ' + error.message);
                    });
                } else {
                    console.log('Geolocation tidak didukung di browser ini.');
                }
            }

            $('#optionDelivery').on('click', function() {
                $('#deliveryForm').slideToggle();
            });

            $('input[name="delivery_method"]').on('change', function() {
                $('#selectBtn').prop('disabled', false);
            });

            $('#selectBtn').on('click', function() {
                if ($('input[name="delivery_method"]:checked').val() == 'pickup') {
                    $('#pickupModal').modal('show');
                    pickup();
                }
                if ($('input[name="delivery_method"]:checked').val() == 'delivery') {
                    // show modal
                    $('#deliveryModal').modal('show');
                    address_get();
                }
            });

            function address_get() {
                // get address
                // reset selected_address
                $('#selected_address').empty();
                $.ajax({
                    url: "{{ route('customer.address.index') }}",
                    type: "GET",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        var data = response;
                        for (const key in data) {
                            const d = data[key];
                            $('#selected_address').append("<option value='" + d.address + "'>" + d
                                .address +
                                "</option>");
                        }
                    },
                    error: function(xhr) {
                        // Tangani error (misalnya validasi gagal)
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            }

            $('#addressForm').on('submit', function(e) {
                e.preventDefault(); // Mencegah form submit default

                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('customer.address.create') }}",
                    type: "POST",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // Tangani respon sukses
                        alert('Address berhasil disimpan!');
                        $('#addressForm')[0].reset();
                        // Contoh: tutup modal
                        $('#addressModal').modal('hide');
                        // Contoh: refresh data yang muncul di halaman (jika perlu)
                        location.reload();
                    },
                    error: function(xhr) {
                        // Tangani error (misalnya validasi gagal)
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
