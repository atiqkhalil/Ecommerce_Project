<header>
    <div class="container-fluid">
        <div class="row py-3 border-bottom">

            <div class="col-sm-4 col-lg-3 text-center text-sm-start">
                <div class="main-logo">
                    <a href="index.html">
                        <img src="{{ asset('front-assets/images/logo.png') }}" alt="logo" class="img-fluid">
                    </a>
                </div>
            </div>

            <div class="col-sm-6 offset-sm-2 offset-md-0 col-lg-5 d-none d-lg-block">
                <div class="search-bar row bg-light p-2 my-2 rounded-4">
                    <div class="col-md-4 d-none d-md-block">
                        <select class="form-select border-0 bg-transparent" onchange="location = this.value;">
                            <option value="" disabled {{ empty($CategorySelected) ? 'selected' : '' }}>All
                                Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ route('front.shop', $category->slug) }}"
                                    {{ isset($CategorySelected) && $CategorySelected == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-11 col-md-7">
                        <form id="search-form" class="text-center" action="{{ route('front.shop') }}" method="get">
                            <input type="text" value="{{ Request::get('search') }}" name="search" class="form-control border-0 bg-transparent"
                                placeholder="Search for more than 20,000 products" />
                        
                    </div>
                    <div class="col-1">
                        <button type="submit" class="btn btn-link p-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M21.71 20.29L18 16.61A9 9 0 1 0 16.61 18l3.68 3.68a1 1 0 0 0 1.42 0a1 1 0 0 0 0-1.39ZM11 18a7 7 0 1 1 7-7a7 7 0 0 1-7 7Z" />
                            </svg>
                        </button>
                    </div> </form>
                </div>
            </div>

            <div
                class="col-sm-8 col-lg-4 d-flex justify-content-end gap-5 align-items-center mt-4 mt-sm-0 justify-content-center justify-content-sm-end">
                <div class="support-box text-end d-none d-xl-block">
                    <span class="fs-6 text-muted">For Support?</span>
                    <h5 class="mb-0">+980-34984089</h5>
                </div>


                @if (Auth::check())
                    <div class="support-box text-end d-none d-xl-block" style="min-width: 120px;">
                        <a href="{{ route('account.profile',Auth::user()->id) }}" class="fs-6 text-muted fw-bold text-decoration-none">My Account</a>
                    </div>
                @endif
                
                <ul class="d-flex justify-content-end list-unstyled m-0">
                    <li>
                        @if (Auth::check())
                        <a href="{{ route('logout') }}" class="rounded-circle bg-light p-2 mx-1" 
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                         <img src="https://www.svgviewer.dev/static-svgs/33599/logout.svg" alt="Logout" width="24" height="24">
                     </a>
                     <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                        @else
                        <a href="{{ route('account.register') }}" class="rounded-circle bg-light p-2 mx-1">
                            <svg width="24" height="24" viewBox="0 0 24 24">
                                <use xlink:href="#user"></use>
                            </svg>
                        </a>
                     @endif                      
                    </li>
                    <li>
                        <a href="{{ route('mywishlist') }}" class="rounded-circle bg-light p-2 mx-1">
                            <svg width="24" height="24" viewBox="0 0 24 24">
                                <use xlink:href="#heart"></use>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('front.cart') }}" class="rounded-circle bg-light p-2 mx-1" >
                            <svg width="24" height="24" viewBox="0 0 24 24">
                                <use xlink:href="#cart"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="d-lg-none">
                        <a href="{{ route('front.cart') }}" class="rounded-circle bg-light p-2 mx-1" >
                            <svg width="24" height="24" viewBox="0 0 24 24">
                                <use xlink:href="#cart"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="d-lg-none">
                        <a href="#" class="rounded-circle bg-light p-2 mx-1" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasSearch" aria-controls="offcanvasSearch">
                            <svg width="24" height="24" viewBox="0 0 24 24">
                                <use xlink:href="#search"></use>
                            </svg>
                        </a>
                    </li>
                </ul>

                {{-- <div class="cart text-end d-none d-lg-block dropdown">
                    <button class="border-0 bg-transparent d-flex flex-column gap-2 lh-1" type="button"
                        data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
                        <span class="fs-6 text-muted dropdown-toggle">Your Cart</span>
                        <span class="cart-total fs-5 fw-bold">$1290.00</span>
                    </button>
                </div> --}}
            </div>

        </div>
    </div>
    <div class="container-fluid">
        <div class="row py-3">
            <div class="d-flex  justify-content-center justify-content-sm-between align-items-center">
                <nav class="main-menu d-flex navbar navbar-expand-lg">

                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                        aria-labelledby="offcanvasNavbarLabel">

                        <div class="offcanvas-header justify-content-center">
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>

                        <div class="offcanvas-body">

                            <select class="filter-categories border-0 mb-0 me-5" onchange="location = this.value;">
                                <option value="" disabled {{ empty($CategorySelected) ? 'selected' : '' }}>Shop by
                                    Departments</option>
                                @foreach ($categories as $category)
                                    <option value="{{ route('front.shop', $category->slug) }}"
                                        {{ isset($CategorySelected) && $CategorySelected == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>




                            <ul class="navbar-nav justify-content-end menu-list list-unstyled d-flex gap-md-3 mb-0">
                                @foreach ($categories as $category)
                                    <li class="nav-item dropdown">
                                        @if ($category->subcategories->isNotEmpty())
                                            <a href="#" class="nav-link dropdown-toggle" role="button"
                                                id="category-{{ $category->id }}" data-bs-toggle="dropdown"
                                                aria-expanded="false">{{ $category->name }}</a>
                                            <ul class="dropdown-menu" aria-labelledby="category-{{ $category->id }}">
                                                @foreach ($category->subcategories as $subcategory)
                                                    <li><a href="{{ route('front.shop', [$category->slug, $subcategory->slug]) }}"
                                                            class="dropdown-item">{{ $subcategory->name }}</a></li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <a href="{{ route('front.shop', $category->slug) }}"
                                                class="nav-link">{{ $category->name }}</a>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
            </div>
        </div>
    </div>
</header>
