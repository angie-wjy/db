<nav>
    <ul class="nav_links">
        <li class="link"><a href="#">Home</a></li>
        <li class="link"><a href="#">Shop</a></li>
        <li class="link"><a href="#">Pages</a></li>
        <li class="link"><a href="#">Contact</a></li>
    </ul>
    @auth
    <div class="nav_logo" style="margin-right: 2rem;">
        <a href="/home">
            <img src="{{ asset('assets/logo_smile.png') }}" alt="Your Image">
        </a>
    </div>
    @else
    <div class="nav_logo" style="margin-right: 2rem;">
        <a href="/">
            <img src="{{ asset('assets/logo_smile.png') }}" alt="Your Image">
        </a>
    </div>
    @endauth
    <form class="d-flex" role="search" method="GET" action="/product/search">
        <input class="form-control me-2" type="search" placeholder="Search" name="search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
    @auth
    <div class="nav_icons">
        <span>
            <a href="#"><i class="ri-user-line"> Hi, {{auth()->user()->username}} </i></a>
        </span>
        <span>
            <a href="/cart"><i class="ri-shopping-bag-line">Cart</i></a>
        </span>
        <span>
            <form action="/signout" method="post">
                @csrf
                <button type="submit" class="btn btn-danger">
                   <i class="ri-logout-box-line"></i> SignOut
                </button>
            </form>
        </span>
    </div>
    @else
    <div class="nav_icons">
        <span>
            <a href="/signin"><i class="ri-user-line">SignIn</i></a>
        </span>
        <span>

            <a href="/signup"><i class="ri-user-line">Signup</i></a>
        </span>
        <span>
            <a href="#"><i class="ri-shopping-bag-line"></i> cart</a>
        </span>
    </div>
    @endauth
</nav>
