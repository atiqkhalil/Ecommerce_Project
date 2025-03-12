@extends('front.layout.app')

@include('front.yourcart')

@include('front.mobilesearch')

@include('front.header')

<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.home') }}">My Account</a></li>
                <li class="breadcrumb-item">Settings</li>
            </ol>
        </div>
    </div>
</section>



<section class="section-11">
    <div class="container mt-5">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                @include('account.common.sidebar')
            </div>

            <!-- Profile Section -->
            <div class="col-md-9">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-dark">
                        <h2 class="h5 mb-2 pt-2 pb-2">My Wishlist</h2>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="card-body p-4">
                        @if ($wishlists->isNotEmpty())
                            @foreach ($wishlists as $wishlist)
                                <div class="d-sm-flex justify-content-between mt-lg-4 mb-4 pb-3 pb-sm-2 border-bottom">
                                    <div class="d-block d-sm-flex align-items-start text-center text-sm-start">
                                        <a class="d-block flex-shrink-0 mx-auto me-sm-4"
                                            href="{{ route('front.product', $wishlist->product->slug) }}"
                                            style="width: 10rem;">
                                            @foreach ($wishlist->product->images as $image)
                                                <img src="{{ asset('storage/' . $wishlist->product->images->first()->image) }}"
                                                    alt="Product" style="max-width: 100%; height: auto;">
                                            @endforeach
                                        </a>
                                        <div class="pt-2">
                                            <h3 class="product-title fs-base mb-2"><a
                                                    href="{{ route('front.product', $wishlist->product->slug) }}">{{ $wishlist->product->title }}</a>
                                            </h3>
                                            <div class="fs-lg text-accent pt-2">
                                                ${{ number_format($wishlist->product->price, 2) }}</div>
                                        </div>
                                    </div>
                                    <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center">
                                        <form action="{{ route('deletewishlist', $wishlist->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="fas fa-trash-alt me-2"></i>Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>No wishlist items found.</p>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@include('front.footer')

<style>
    .text-danger1 {
        color: #dc3545 !important;
        font-size: 0.875rem;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
