<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
        </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
        </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
        </script>
    <link rel="stylesheet" href="{{ asset('assets/css/welcome.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Smile Gift Shop</title>
</head>

<body>
    {{-- @include('component.nav_customer') --}}
    <nav>
        @auth
            <div class="nav_logo">
                <a href="/home">
                    <img src="{{ asset('assets/logo_smile.png') }}" alt="Your Image">
                </a>
            </div>
        @else
            <div class="nav_logo">
                <a href="/">
                    <img src="{{ asset('assets/logo_smile.png') }}" alt="Your Image">
                </a>
            </div>
        @endauth

        <ul class="nav_links">
            <li class="link"><a href="/home">Home</a></li>
            <li class="link"><a href="/home#categories">Category</a></li>
            {{-- <li class="link dropdown">
                <a class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    Category
                </a>
                <div class="dropdown-menu border-0 shadow rounded" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item py-2" href="{{ route('category.show', 'Pillow') }}">Pillow</a>
                    <a class="dropdown-item py-2" href="{{ route('category.show', 'Doll') }}">Doll</a>
                    <a class="dropdown-item py-2" href="{{ route('category.show', 'Fancy') }}">Fancy</a>
                    <a class="dropdown-item py-2" href="{{ route('category.show', 'Bag') }}">Bag</a>
                </div>
            </li> --}}
            <li class="link"><a href="#">Pages</a></li>
            <li class="link" style="margin-right: 10px;"><a href="#">Contact</a></li>
        </ul>

        <div class="nav_right">
            <form class="d-flex" role="search" method="GET" action="/product/search">
                <input class="form-control me-2" type="search" placeholder="Search" name="search" aria-label="Search">
                <button class="btn" type="submit" id='search'>SEARCH</button>
            </form>
            @isset(Auth::guard('customer')->user()->id)
                <div class="nav_icons">
                    <span>
                        <a href="#"><i class="ri-user-line"> Hi, {{ Auth::guard('customer')->user()->name }} </i></a>
                    </span>
                    <span>
                        <a href="/cart"><i class="ri-shopping-bag-line">Cart</i></a>
                        @php $cart = session('cart'); @endphp
                        @if ($cart)
                            <span class="badge badge-danger"
                                style="position: absolute;">
                                {{ array_sum(array_column($cart, 'quantity')) }}
                            </span>
                        @endif
                    </span>
                    <span>
                        <form action="{{ route('signout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">
                                <i class="ri-logout-box-line"></i> Log Out
                            </button>
                        </form>
                    </span>
                </div>
            @else
                <div class="nav_icons">
                    <span><a class='btn' href="/login">Login</i></a></span>
                </div>
            @endisset
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    {{-- <footer class="section_container footer_container">
        <div class="footer_col">
            <h4>CONTACT INFO</h4>
            <p>
                <span><i class="ri-map-pin-2-fill"></i></span>
                123, London Bridge Street, London
            </p>
            <p>
                <span><i class="ri-mail-fill"></i></span>
                support@Lebaba.com
            </p>
            <p>
                <span><i class="ri-phone-fill"></i></span>
                0812 6170 0500
            </p>
        </div>
        <div class="footer_col">
            <h4>COMPANY</h4>
            <a href="#">Home</a>
            <a href="#">About Us</a>
            <a href="#">Work With Us</a>
            <a href="#">Our Blog</a>
            <a href="#">Terms & Conditions</a>
        </div>
        <div class="footer_col">
            <h4>USEFUL LINK</h4>
            <a href="#">Help</a>
            <a href="#">Track My Order</a>
            <a href="#">Men</a>
            <a href="#">Women</a>
            <a href="#">Dresses</a>
        </div>
        <div class="footer_col">
            <h4>E-Commerce</h4>
            <div class="instagram_grid">
                <img src="assets/instagram-1.jpg" alt="instagram" />
                <img src="assets/instagram-2.jpg" alt="instagram" />
                <img src="assets/instagram-3.jpg" alt="instagram" />
                <img src="assets/instagram-4.jpg" alt="instagram" />
                <img src="assets/instagram-5.jpg" alt="instagram" />
                <img src="assets/instagram-6.jpg" alt="instagram" />
            </div>
        </div>
    </footer> --}}
</body>
<script src="/assets/js/setting-demo2.js"></script>
<script>
    $(document).ready(function () {
        $("#basic-datatables").DataTable({});

        $("#multi-filter-select").DataTable({
            pageLength: 5,
            initComplete: function () {
                this.api()
                    .columns()
                    .every(function () {
                        var column = this;
                        var select = $(
                            '<select class="form-select"><option value=""></option></select>'
                        )
                            .appendTo($(column.footer()).empty())
                            .on("change", function () {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());

                                column
                                    .search(val ? "^" + val + "$" : "", true, false)
                                    .draw();
                            });

                        column
                            .data()
                            .unique()
                            .sort()
                            .each(function (d, j) {
                                select.append(
                                    '<option value="' + d + '">' + d + "</option>"
                                );
                            });
                    });
            },
        });

        // Add Row
        $("#add-row").DataTable({
            pageLength: 5,
        });

        var action =
            '<td> <div class="form-button-action"> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

        $("#addRowButton").click(function () {
            $("#add-row")
                .dataTable()
                .fnAddData([
                    $("#addName").val(),
                    $("#addPosition").val(),
                    $("#addOffice").val(),
                    action,
                ]);
            $("#addRowModal").modal("hide");
        });
    });
</script>

</html>
