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
            <li class="link"><a href="#">Home</a></li>
            <li class="link dropdown">
                <a class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
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
            <img src="{{ asset('assets/logo.png') }}" alt="header" style="width: 40rem;">
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
                <div>
                    <p>2024 Trend</p>
                    <h4>Labubu</h4>
                </div>
                <a href="#">Discover More +</a>
            </div>
        </div>
        <div class="hero_card">
            <img src="{{ asset('assets/capybara_bird.jpg') }}" alt="hero">
            <div class="hero_content">
                <div>
                    <p>2024 Trend</p>
                    <h4>Sanrio</h4>
                </div>
                <a href="#">Discover More +</a>
            </div>
        </div>
        <div class="hero_card">
            <img src="{{ asset('assets/capybara_carrot.jpg') }}" alt="hero">
            <div class="hero_content">
                <div>
                    <p>2024 Trend</p>
                    <h4>Lotso</h4>
                </div>
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
                <img src="{{ asset('assets/capybara_baseball.jpg') }}" alt="product">
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
                <img src="{{ asset('assets/capybara_baseball.jpg') }}" alt="product">
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
                <img src="{{ asset('assets/capybara_baseball.jpg') }}" alt="product">
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
                <img src="{{ asset('assets/capybara_baseball.jpg') }}" alt="product">
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
                <img src="{{ asset('assets/capybara_baseball.jpg') }}" alt="product">
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
                <img src="{{ asset('assets/capybara_baseball.jpg') }}" alt="product">
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
                <img src="{{ asset('assets/capybara_baseball.jpg') }}" alt="product">
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
