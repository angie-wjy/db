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
    <title>Smile Gift Shop</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Poppins:wght@400;500;600;700&display=swap');

        :root {
            --primary-color: #fbf404;
            --primary-color-dark: #f8d70a;
            --primary-color-light: #eee9e7;
            --text-dark: #262220;
            --text-light: #7c7c79;
            --extra-light: #f8fafc;
            --white: #ffffff;
            --header-font: "Playfair Display", serif;
        }

        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        .section_container {
            max-width: 1400px;
            margin: auto;
            padding: 5rem 1rem;
        }

        .section_header {
            margin-bottom: 1rem;
            font-size: 2rem;
            font-weight: 800;
            font-family: var(--header-font);
            text-align: center;
        }

        .section_subheader {
            max-width: 500px;
            margin: auto;
            color: var(--text-light);
            text-align: center;
        }

        .btn {
            padding: .75rem 1.5rem;
            outline: none;
            border: none;
            font-size: 1rem;
            color: var(--white);
            background-color: var(--primary-color);
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn:hover {
            background-color: var(--primary-color-dark);
        }

        .img {
            width: 100%;
            display: flex;
        }

        a {
            text-decoration: none;
        }

        body {
            font-family: 'Poppins', sans-serif;
        }

        nav {
            max-width: 1200px;
            /* margin-bottom: .5rem; */
            margin-left: 40px;
            padding: 2rem .5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nav_links {
            flex: 1;
            list-style: none;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-top: 1rem;
        }

        .link a {
            font-weight: 500;
            color: var(--text-dark);
        }

        .link a:hover {
            color: var(--primary-color);
        }

        .link.dropdown {
            position: relative;
        }

        .link.dropdown .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
        }

        .link .dropdown:hover {
            color: var(--primary-color);
        }

        .nav_logo img {
            width: 100px;
            height: auto;
            border-radius: 20px;
            transition: transform 0.3s ease;
        }

        .nav_logo img:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }

        .nav_icons {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 2rem;
            margin-left: 20px;
        }

        .nav_icons span a {
            font-size: 1.25rem;
            color: var(--text-dark);
        }

        .nav_icons span a:hover {
            color: var(--primary-color);
        }

        .header_container {
            min-height: 650px;
            background-color: var(--primary-color-light);
            border-bottom-left-radius: 1rem;
            border-bottom-right-radius: 1rem;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
            align-items: center;
        }

        .header_content {
            max-width: 600px;
            margin-left: auto;
        }

        .header_content h4 {
            font-size: 1rem;
            font-weight: 500;
            color: var(--primary-color);
        }

        .header_content h1 {
            font-size: 5rem;
            font-weight: 800;
            font-family: var(--header-font);
            color: var(--text-dark);
        }

        .header_content p {
            margin-bottom: 2rem;
            color: var(--text-light);
        }

        .header_image {
            position: relative;
            height: 100%;
        }

        .height_image img {
            position: absolute;
            left: 50%;
            bottom: -5rem;
            transform: translateX(-50%);
            max-width: 500px;
        }

        .categories_grid {
            max-width: 900px;
            min-height: 100px;
            margin: auto;
            margin-top: 4rem;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
        }

        .categories_grid h4 {
            font-size: 1.2rem;
            font-weight: 600;
            font-family: var(--header-font);
            color: var(--text-dark);
        }

        .categories_card {
            text-align: center;
        }

        .categories_card img {
            max-width: 100px;
            margin: auto;
            margin-bottom: 1rem;
            border: 5px solid var(--white);
            border-radius: 100%;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .categories_card h4 {
            font-size: 1.2rem;
            font-weight: 600;
            font-family: var(--header-font);
            color: var(--text-dark);
        }

        .hero_container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
        }

        .hero_card {
            position: relative;
            box-shadow: 2px 2px 20px rgba(0, 0, 0, 0.1);
        }

        .hero_content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-15%, -50%);
        }

        .hero_content p {
            font-size: .9rem;
            font-weight: 500;
            color: var(--primary-color);
        }

        .hero_content h4 {
            margin-bottom: 1rem;
            font-size: 1.25rem;
            font-weight: 800;
            font-family: var(--header-font);
            color: var(--text-dark);
        }

        .hero_content a {
            color: var(--text-dark);
            text-decoration: under;
        }

        .hero_card img {
            border-radius: 5px;
            width: auto%;
            height: auto;
            max-height: 200px;
        }

        .product_grid {
            max-width: 900px;
            margin: 4rem auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
        }

        .product_card_content {
            text-align: center;
            padding: 1rem;
        }

        .product_rating {
            margin-bottom: 5px;
            font-size: 0.8rem;
            color: yellow;
        }

        .product_card_content h4 {
            margin-bottom: 5px;
            font-size: 1.2rem;
            font-weight: 800;
            font-family: var(--header-font);
        }

        .product_card_content p {
            font-weight: 500;
            color: var(--text-dark);
        }

        .product_card_content p s {
            font-size: 0.9rem;
            font-weight: 400;
            color: var(--text-light);
        }

        .product_btn {
            text-align: center;
        }

        .product_card img {
            width: 100%;
            /* Agar gambar memenuhi lebar card */
            height: 200px;
            /* Menentukan tinggi gambar agar seragam */
            object-fit: cover;
            /* Memastikan gambar tetap terlihat proporsional */
            border-radius: 10px;
            /* Membuat sudut gambar lebih halus */
            transition: transform 0.3s ease-in-out;
        }

        .product_card:hover img {
            transform: scale(1.05);
            /* Efek zoom saat hover */
        }


        .deals_container {
            background-color: var(--primary-color-light);
            border-radius: 1rem;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
            align-items: center;
        }

        .deals_image {
            height: 100%;
            position: relative;
        }

        .deals_image img {
            position: absolute;
            left: 50%;
            bottom: -5rem;
            transform: translateX(-50%);
            max-width: 550px;
        }

        .deals_content {
            max-width: 600px;
            margin-right: auto;
        }

        .deals_content h5 {
            margin-bottom: 1rem;
            font-size: 1rem;
            font-weight: 500;
            color: var(--primary-color);
        }

        .deals_content h4 {
            margin-bottom: 1rem;
            font-size: 2rem;
            font-weight: 800;
            font-family: var(--header-font);
            color: var(--text-dark);
        }

        .deals_content p {
            margin-bottom: 2rem;
            color: var(--text-light);
        }

        .deals_countdown {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .deals_countdown_card {
            height: 80px;
            width: 80px;
            display: grid;
            place-content: center;
            text-align: center;
            background-color: var(--white);
            border-radius: 100%;
            box-shadow: 5px 5px 20px rgba(0, 0, 0, 0.1);
        }

        .deals_countdown_card h4 {
            margin-bottom: 0;
            font-size: 1.5rem;
            color: var(--text-dark);
        }

        .deals_countdown_card p {
            margin-bottom: 0;
            font-weight: 500;
            color: var(--text-dark);
        }

        .banner_container {
            max-width: 900px;
            margin: auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }

        .banner_card {
            text-align: center;
        }

        .banner_card span {
            margin-bottom: 1rem;
            display: inline-block;
            font-size: 2rem;
            color: var(--primary-color);
        }

        .banner_card h4 {
            margin-bottom: 0.5rem;
            font-size: 1.25rem;
            font-family: var(--header-font);
            color: var(--text-dark);
        }

        .banner_card p {
            color: var(--text-light);
        }

        .blog_container {
            background-color: var(--extra-light);
            border-radius: 1rem;
        }

        .blog_grid {
            max-width: 900px;
            margin: auto;
            margin-top: 4rem;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }

        .blog_card {
            background-color: var(--white);
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 2px 2px 20px rgba(0, 0, 0, 0.1);
        }

        .blog_card_content {
            padding: 1rem;
            text-align: center;
        }

        .blog_card_content h6 {
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--primary-color);
        }

        .blog_card_content h4 {
            margin-bottom: 0.5rem;
            font-size: 1.2rem;
            font-family: var(--header-font);
            color: var(--text-dark);
        }

        .blog_card_content p {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-light);
        }

        .footer_container {
            max-width: 1200px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
        }

        .footer_container h4 {
            margin-bottom: 1.5rem;
            font-size: 1.2rem;
            font-weight: 800;
            font-family: var(--header-font);
            color: var(--text-dark);
        }

        .footer_col p {
            margin-bottom: 1rem;
            font-weight: 500;
            color: var(--text-light);
        }

        .footer_col p span {
            margin-right: 0.5rem;
            font-size: 1.2rem;
            color: var(--primary-color);
        }

        .footer_col a {
            display: block;
            margin-bottom: 1rem;
            font-weight: 500;
            color: var(--text-light);
        }

        .footer_col a:hover {
            color: var(--primary-color);
        }

        .instagram_grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
        }

        .footer_bar {
            padding: 1rem;
            text-align: center;
            font-size: 0.8rem;
            color: var(--text-light);
            border-top: 2px solid var(--extra-light);
        }
    </style>
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
            <li class="link"><a href="#">Home</a></li>
            <li class="link dropdown">
                <a class="dropdown-toggle text-dark text-decoration-none" id="dropdownMenuButton" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    Category
                </a>
                <div class="dropdown-menu border-0 shadow rounded" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item py-2" href="{{ route('category.show', 'bantal') }}">Bantal</a>
                    <a class="dropdown-item py-2" href="{{ route('category.show', 'boneka') }}">Boneka</a>
                    <a class="dropdown-item py-2" href="{{ route('category.show', 'fancy') }}">Fancy</a>
                    <a class="dropdown-item py-2" href="{{ route('category.show', 'tas') }}">Tas</a>
                </div>
            </li>
            <li class="link"><a href="#">Pages</a></li>
            <li class="link" style="margin-right: 10px;"><a href="#">Contact</a></li>
        </ul>

        <form class="d-flex" role="search" method="GET" action="/product/search">
            <input class="form-control me-2" type="search" placeholder="Search" name="search" aria-label="Search"
                style="width: 280px;">
            <button class="btn btn-outline-success" type="submit"
                style="width: 80px; padding-left: 10px; padding-right: 10px;">Search</button>
        </form>
        @isset(Auth::guard('customer')->user()->id)
            <div class="nav_icons">
                <span>
                    <a href="#"><i class="ri-user-line"> Hi, {{ Auth::guard('customer')->user()->name }} </i></a>
                </span>
                <span>
                    <a href="/cart"><i class="ri-shopping-bag-line">Cart</i></a>
                </span>
                <span>
                    <form action="{{ route('signout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger" style="margin-right: -160px;">
                            <i class="ri-logout-box-line"></i> Log Out
                        </button>
                    </form>
                </span>
            </div>
        @else
            <div class="nav_icons">
                <form action="{{ route('login') }}" method="GET">
                    <button type="submit" class="btn btn-danger" style="margin-right: -160px;">
                        <i class="ri-logout-box-line"></i> Login
                    </button>
                </form>
                {{-- <span>
                        <a href="/login"><i class="ri-user-line">Login</i></a> --}}
                {{-- <span>
                        <a href="/signup"><i class="ri-user-line">SignUp</i></a>
                    </span> --}}

            </div>
        @endisset
    </nav>
    <header class="section_container header_container">
        <div class="header_content">
            <h4>UP TO 20% DISCOUNT ON</h4>
            <h1>Girl's Accessories</h1>
            <p>This shop in Surabaya offers a charming selection of items, including plush toys, pillows, bags,
                accessories, and various novelty products. Perfect for gift-giving or adding a touch of fun to daily
                life, the shop features high-quality items that bring a smile to any occasion.</p>
            <button class="btn">SHOP NOW</button>
        </div>
        <div class="header_image">
            <img src="{{ asset('assets/LOGO.jpg') }}" alt="header" style="width: 40rem;">
        </div>
    </header>

    <section class="section_container top_selling_container mt-4">
        <h2 class="section_header m-3">Top Selling</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach ($products as $p)
                <div class="col">
                    <a href="/product/detail/{{ $p->id }}">
                        <div class="card h-100">
                            <img src="{{ asset('storage/' . $p->image) }}" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title" style="font-weight: bold">{{ $p->name }}</h5>
                                {{-- <p class="">{{ number_format($p->price, 0, 0, '.') }}</p>
                                    <p class="card-text">{{ $p->description }}</p> --}}
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
    </section>

    <section class="section_container categories_container">
        <h2 class="section_header">Categories</h2>
        <p class="section_subheader">
            Explore a diverse range of charming items, from cozy pillows and adorable plush toys to stylish bags,
            stationery, mugs, and bottles. Add a touch of fun and functionality to your everyday life today!
        </p>
        <div class="categories_grid">
            @foreach ($categories as $c)
                <a href="/product/category/{{ $c->code }}">
                    <div class="categories_card">
                        @if ($c->products->isNotEmpty())
                            <img src="{{ asset($c->products->first()->image) }}" alt="{{ $c->name }}">
                        @else
                            <img src="{{ asset('default-image.jpg') }}" alt="No image available">
                        @endif
                        <h4>{{ $c->brand }}</h4>
                    </div>
                </a>
            @endforeach
    </section>

    <section class="section_container hero_container">
        {{-- <h2 class="section_header">Trend</h2> --}}
        <div class="hero_card">
            <img src="{{ asset('assets/capybara_baseball.jpg') }}" alt="hero">
            <div class="hero_content">
                <p>2024 Trend</p>
                <h4>Labubu</h4>
                <a href="#">Discover More +</a>
            </div>
        </div>
        <div class="hero_card">
            <img src="{{ asset('assets/capybara_bird.jpg') }}" alt="hero">
            <div class="hero_content">
                <p>2024 Trend</p>
                <h4>Sanrio</h4>
                <a href="#">Discover More +</a>
            </div>
        </div>
        <div class="hero_card">
            <img src="{{ asset('assets/capybara_carrot.jpg') }}" alt="hero">
            <div class="hero_content">
                <p>2024 Trend</p>
                <h4>Lotso</h4>
                <a href="#">Discover More +</a>
            </div>
        </div>
    </section>

    <section class="section_container product_container">
        <h2 class="section_header">Trending Products</h2>
        <p class="section_subheader">
            Discover the Cutest Picks: Elevate Your Collection with Our Curated Selection of Adorable Plush Toys!
        </p>
        <div class="product_grid">
            <div class="product_card">
                <img src="{{ asset('assets/capybara_baseball.jpg') }}" alt="product">
                <div class="product_card_content">
                    <div class="product_rating">
                        <span><i class="ri-star-fill"></i></span>
                        <span><i class="ri-star-fill"></i></span>
                        <span><i class="ri-star-fill"></i></span>
                        <span><i class="ri-star-half-line"></i></span>
                        <span><i class="ri-star-line"></i></span>
                    </div>
                    <h4>Boneka Capybara Baseball</h4>
                    <p>75.000 <s>100.000</s></p>
                </div>
            </div>
            <div class="product_card">
                <img src="" alt="product">
                <div class="product_card_content">
                    <div class="product_rating">
                        <span><i class="ri-star-fill"></i></span>
                        <span><i class="ri-star-fill"></i></span>
                        <span><i class="ri-star-fill"></i></span>
                        <span><i class="ri-star-half-line"></i></span>
                        <span><i class="ri-star-line"></i></span>
                    </div>
                    <h4>Boneka Lotso Giant</h4>
                    <p>319.900 <s>255.920</s></p>
                </div>
            </div>
            <div class="product_card">
                <img src="" alt="product">
                <div class="product_card_content">
                    <div class="product_rating">
                        <span><i class="ri-star-fill"></i></span>
                        <span><i class="ri-star-fill"></i></span>
                        <span><i class="ri-star-fill"></i></span>
                        <span><i class="ri-star-half-line"></i></span>
                        <span><i class="ri-star-line"></i></span>
                    </div>
                    <h4>Boneka Lotso Giant</h4>
                    <p>319.900 <s>255.920</s></p>
                </div>
            </div>
            <div class="product_card">
                <img src="" alt="product">
                <div class="product_card_content">
                    <div class="product_rating">
                        <span><i class="ri-star-fill"></i></span>
                        <span><i class="ri-star-fill"></i></span>
                        <span><i class="ri-star-fill"></i></span>
                        <span><i class="ri-star-half-line"></i></span>
                        <span><i class="ri-star-line"></i></span>
                    </div>
                    <h4>Boneka Lotso Giant</h4>
                    <p>319.900 <s>255.920</s></p>
                </div>
            </div>
            <div class="product_card">
                <img src="" alt="product">
                <div class="product_card_content">
                    <div class="product_rating">
                        <span><i class="ri-star-fill"></i></span>
                        <span><i class="ri-star-fill"></i></span>
                        <span><i class="ri-star-fill"></i></span>
                        <span><i class="ri-star-half-line"></i></span>
                        <span><i class="ri-star-line"></i></span>
                    </div>
                    <h4>Boneka Lotso Giant</h4>
                    <p>319.900 <s>255.920</s></p>
                </div>
            </div>
            <div class="product_card">
                <img src="" alt="product">
                <div class="product_card_content">
                    <div class="product_rating">
                        <span><i class="ri-star-fill"></i></span>
                        <span><i class="ri-star-fill"></i></span>
                        <span><i class="ri-star-fill"></i></span>
                        <span><i class="ri-star-half-line"></i></span>
                        <span><i class="ri-star-line"></i></span>
                    </div>
                    <h4>Boneka Lotso Giant</h4>
                    <p>319.900 <s>255.920</s></p>
                </div>
            </div>
            <div class="product_card">
                <img src="" alt="product">
                <div class="product_card_content">
                    <div class="product_rating">
                        <span><i class="ri-star-fill"></i></span>
                        <span><i class="ri-star-fill"></i></span>
                        <span><i class="ri-star-fill"></i></span>
                        <span><i class="ri-star-half-line"></i></span>
                        <span><i class="ri-star-line"></i></span>
                    </div>
                    <h4>Boneka Lotso Giant</h4>
                    <p>319.900 <s>255.920</s></p>
                </div>
            </div>
            <div class="product_card">
                <img src="" alt="product">
                <div class="product_card_content">
                    <div class="product_rating">
                        <span><i class="ri-star-fill"></i></span>
                        <span><i class="ri-star-fill"></i></span>
                        <span><i class="ri-star-fill"></i></span>
                        <span><i class="ri-star-half-line"></i></span>
                        <span><i class="ri-star-line"></i></span>
                    </div>
                    <h4>Boneka Lotso Giant</h4>
                    <p>319.900 <s>255.920</s></p>
                </div>
            </div>
        </div>
        <div class="product_btn">
            <button class="btn">Load More</button>
        </div>
    </section>

    <section class="section_container deals_container">
        <div class="deals_image">
            <img src="" alt="deals">
        </div>
        <div class="deals_content">
            <h5>Get Up To 20% Discount</h5>
            <h4>Deals Of This Month</h4>
            <p>Our Plush Toy Deals of the Month are here to bring joy without breaking the bank. Discover a curated
                collection of adorable stuffed animals, pillows, and novelty items, all handpicked to brighten any
                space
                or make the perfect gift.</p>
            <div class="deals_countdown">
                <div class="deals_countdown_card">
                    <h4>14</h4>
                    <p>Days</p>
                </div>
                <div class="deals_countdown_card">
                    <h4>20</h4>
                    <p>Hours</p>
                </div>
                <div class="deals_countdown_card">
                    <h4>15</h4>
                    <p>Mins</p>
                </div>
                <div class="deals_countdown_card">
                    <h4>05</h4>
                    <p>Secs</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section_container banner_container">
        <div class="banner_card">
            <span><i class="ri-truck-line"></i></span>
            <h4>Delivery & Pick Up</h4>
            <p>Convenient options to shop anywhere, with delivery to your door or easy in-store pick up.</p>
        </div>
        <div class="banner_card">
            <span><i class="ri-money-dollar-circle-line"></i></span>
            <h4>Flexible Payment Options</h4>
            <p>Enjoy the convenience of paying your way with options including cash, bank transfer, and e-money.</p>

        </div>
        <div class="banner_card">
            <span><i class="ri-group-fill"></i></span>
            <h4>Strong Support</h4>
            <p>Offer customer support services to assist customers with queries and
                issues.</p>
        </div>
    </section>

    <section class="section_container blog_container">
        <h2 class="section_header">
            <p class="section_subheader">
                Add a touch of charm to your collection with our latest tips, trends, and inspiration on fluffy
                items,
                bags, and accessories.
            </p>
            <div class="blog_grid">
                <div class="blog_card">
                    <img src="" alt="blog">
                    <div class="blog_card_content">
                        <h6>Timeless Elegance</h6>
                        <h4>Mastering the Art of Capsule Wardrobes</h4>
                        <p>12<sup>th</sup> August 2022</p>
                    </div>
                </div>
                <div class="blog_card">
                    <img src="" alt="blog">
                    <div class="blog_card_content">
                        <h6>Timeless Elegance</h6>
                        <h4>Mastering the Art of Capsule Wardrobes</h4>
                        <p>12<sup>th</sup> August 2022</p>
                    </div>
                </div>
                <div class="blog_card">
                    <img src="" alt="blog">
                    <div class="blog_card_content">
                        <h6>Timeless Elegance</h6>
                        <h4>Mastering the Art of Capsule Wardrobes</h4>
                        <p>12<sup>th</sup> August 2022</p>
                    </div>
                </div>
            </div>
        </h2>
    </section>

    <footer class="section_container footer_container">
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
    </footer>
</body>

</html>
