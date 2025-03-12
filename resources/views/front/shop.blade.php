@extends('front.layout.app')

@include('front.yourcart')

@include('front.mobilesearch')

@include('front.header')

<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Shop</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-6">
        <div class="container">
            <div class="row">
                <!-- Sidebar Section -->
                <div class="col-md-3 sidebar">
                    <form id="filterForm">
                        @csrf
                        <div class="sub-title">
                            <h2>Categories</h2>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="accordion accordion-flush" id="accordionExample">
                                    @foreach ($categories as $key => $category)
                                        <div class="accordion-item bg-transparent">
                                            @if ($category->subcategories->isNotEmpty())
                                                <!-- Category with Subcategories -->
                                                <h2 class="accordion-header" id="headingOne-{{ $key }}">
                                                    <button
                                                        class="accordion-button {{ $CategorySelected == $category->id ? '' : 'collapsed' }}"
                                                        type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#collapseOne-{{ $key }}"
                                                        aria-expanded="{{ $CategorySelected == $category->id ? 'true' : 'false' }}"
                                                        aria-controls="collapseOne-{{ $key }}">
                                                        {{ $category->name }}
                                                    </button>
                                                </h2>
                                                <div id="collapseOne-{{ $key }}"
                                                    class="accordion-collapse collapse {{ $CategorySelected == $category->id ? 'show' : '' }}"
                                                    aria-labelledby="headingOne-{{ $key }}"
                                                    data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        @foreach ($category->subcategories as $subcategory)
                                                            <a href="{{ route('front.shop', [$category->slug, $subcategory->slug]) }}"
                                                                class="nav-item nav-link {{ $subCategorySelected == $subcategory->id ? 'text-primary' : '' }}"
                                                                style="margin-left: 15px;">
                                                                {{ $subcategory->name }}
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @else
                                                <!-- Category without Subcategories -->
                                                <a href="{{ route('front.shop', $category->slug) }}"
                                                    class="nav-item nav-link {{ $CategorySelected == $category->id ? 'text-primary' : '' }}"
                                                    style="background-color: #f8f9fa; color: black; font-weight: 502; margin-left: 15px;">
                                                    {{ $category->name }}
                                                </a>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Brand Filter -->
                        <div class="sub-title mt-5">
                            <h2>Brand</h2>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h5>Filter by Brand</h5>
                                @foreach ($brands as $brand)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="brands[]"
                                            value="{{ $brand->id }}" id="brand-{{ $brand->id }}"
                                            {{ in_array($brand->id, $selectedBrands) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="brand-{{ $brand->id }}">
                                            {{ $brand->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Price Filter -->
                        <div class="sub-title mt-5">
                            <h2>Price</h2>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h5>Price</h5>
                                <input type="text" class="js-range-slider" name="price_range" value="" />
                                <input type="hidden" id="min_price" name="min_price" value="{{ $minPrice }}">
                                <input type="hidden" id="max_price" name="max_price" value="{{ $maxPrice }}">
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Products Section -->
                <div class="col-md-9">
                    <div class="row pb-3">
                        {{-- <div class="col-12 pb-1">
                            <div class="d-flex align-items-center justify-content-end mb-4">
                                <div class="ml-2">
                                    <select name="sort" id="sort" class="form-control">
                                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>
                                            Latest</option>
                                        <option value="price_desc"
                                            {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price High</option>
                                        <option value="price_asc"
                                            {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price Low</option>
                                    </select>
                                </div>
                            </div>
                        </div> --}}

                        <!-- Products List -->
                        @if (!$products->isEmpty())
                            @foreach ($products as $product)
                                <div class="col-md-4">
                                    <div class="card product-card">
                                        <div class="product-image position-relative">
                                            <a href="{{ route('front.product',$product->slug) }}" class="product-img">
                                                <img class="card-img-top"
                                                    src="{{ asset('storage/' . $product->images->first()->image) }}"
                                                    alt="">
                                            </a>
                                            {{-- <a class="whishlist" href="222"><i class="far fa-heart"></i></a> --}}
                                            <form action="{{ route('wishlist', $product->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn-wishlist">
                                                    <i class="far fa-heart"></i>
                                              </button>
                                            </form>
                                            <div class="product-action">
                                                @if ($product->track_qty == 'Yes')
                                                @if ($product->qty > 0)
                                                <form action="{{ route('front.addToCart',$product->id) }}" method="post">
                                                  @csrf
                                                    <button class="btn btn-dark w-100"><i class="fas fa-shopping-cart"></i> &nbsp;ADD TO CART</button>
                                              </form>
                                                @else
                                                  <button class="btn btn-danger w-100">OUT OF STOCK</button>
                                                @endif
                                              @else
                                              <form action="{{ route('front.addToCart',$product->id) }}" method="post">
                                                @csrf
                                                  <button class="btn btn-dark w-100"><i class="fas fa-shopping-cart"></i> &nbsp;ADD TO CART</button>
                                            </form>
                                              @endif
                                            </div>
                                        </div>
                                        <div class="card-body text-center">
                                            <a class="h6 link" href="{{ route('front.product',$product->slug) }}">{{ $product->title }}</a>
                                            <div class="price mt-2">
                                                <span class="h5"><strong>${{ $product->price }}</strong></span>
                                                <span
                                                    class="h6 text-underline"><del>${{ $product->compare_price }}</del></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <span class="text-center fs-2">Product Not Available</span>
                        @endif

                        <!-- Pagination -->
                        <div class="col-md-12 pt-5">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-end">
                                    {{ $products->links() }}
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

</main>

@include('front.footer')


<style>
    .product-card {
        height: 100%;
        /* Ensures the product card takes full height of its container */
    }

    .product-image {
        height: 250px;
        /* Fixed height for the product image area */
        overflow: hidden;
        /* Prevents images from overflowing */
    }

    .product-img img {
        width: 100%;
        /* Ensures the image takes the full width of its container */
        height: 100%;
        /* Ensures the image fills the height of its container */
        object-fit: cover;
        /* Maintains aspect ratio and fills the container */
    }

    .card-body {
        min-height: 150px;
        /* Ensure the card body takes up a consistent space */
        margin-top: 0;
        /* Removes the top margin */
    }

    .btn-wishlist {
    position: absolute;
    top: 10px;
    right: 10px;
    background: none;
    border: none;
    padding: 0;
    color: #ff0000; /* Default color */
    cursor: pointer;
    z-index: 10; /* Ensure it's above other elements */
    border-radius: 50%; /* Make the button circular */
    transition: background-color 0.3s, color 0.3s; 
}

.btn-wishlist:hover { /* Change color on hover */
    color: rgb(0, 0, 0)
}
</style>

@section('customjs')
    <script>
        // Handle brand filter and sorting
        document.querySelectorAll('.form-check-input').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                updateFilters();
            });
        });

        document.getElementById('sort').addEventListener('change', function() {
            updateFilters();
        });

        $(document).ready(function() {
            var minPrice = $('#min_price').val();
            var maxPrice = $('#max_price').val();

            var rangeSlider = $(".js-range-slider").ionRangeSlider({
                type: "double",
                min: 0,
                max: 1000,
                from: minPrice,
                to: maxPrice,
                skin: "round",
                prefix: "$",
                grid: true,
                onFinish: function(data) {
                    // Update hidden input values
                    $('#min_price').val(data.from);
                    $('#max_price').val(data.to);

                    // Reload the page with updated filters
                    updateFilters();
                }
            });

            function updateFilters() {
                const form = document.getElementById('filterForm'); // Form containing all filters
                const urlParams = new URLSearchParams(new FormData(form));

                // Add the selected sort option to the URL parameters
                const sortValue = document.getElementById('sort').value;
                urlParams.set('sort', sortValue);

                // Redirect to the updated URL with the filters and sort applied
                const baseUrl = "{{ url()->current() }}"; // Keep the current URL
                window.location.href = `${baseUrl}?${urlParams.toString()}`;
            }
        });
    </script>
@endsection

