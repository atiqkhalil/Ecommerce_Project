@extends('front.layout.app')

@include('front.yourcart')

@include('front.mobilesearch')

@include('front.header')

<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.home') }}">Home</a></li>
                <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.shop') }}">Shop</a></li>
                <li class="breadcrumb-item">{{ $product->title }}</li>
            </ol>
        </div>
    </div>
</section>

<div class="container">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session('success') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session('error') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
</div>

<section class="section-7 pt-3 mb-3">
    <div class="container">
        <div class="row">
           
            <div class="col-md-5">
                <div id="product-carousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner bg-light">
                        <div class="carousel-item active">
                            <img class="w-100 h-100" src="{{ asset('storage/' . $product->images->first()->image) }}"
                                alt="Image">
                        </div>
                    </div>
                    {{-- <a class="carousel-control-prev" href="#product-carousel" data-bs-slide="prev">
                        <i class="fa fa-2x fa-angle-left text-dark"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" data-bs-slide="next">
                        <i class="fa fa-2x fa-angle-right text-dark"></i>
                    </a> --}}
                </div>
            </div>
            <div class="col-md-7">
                <div class="bg-light p-4">
                    <h1>{{ $product->title }}</h1>
                    <div class="d-flex mb-3">
                        <div class="text-primary mr-2">
                            <div class="star-rating mt-2" title="">
                                <div class="back-stars">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>

                                    <div class="front-stars" style="width: {{ $avgRatingPer }}%">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <small class="pt-1">({{ $product->product_ratings_count }} Reviews)</small>
                    </div>
                    <h2 class="price text-secondary"><del>${{ $product->compare_price }}</del></h2>
                    <h2 class="price text-dark">${{ $product->price }}</h2>

                    <p>{!! $product->short_description !!}</p>

                    @if ($product->track_qty == 'Yes')
                        @if ($product->qty > 0)
                            <form action="{{ route('front.addToCart', $product->id) }}" method="post">
                                @csrf
                                <button class="btn btn-dark"><i class="fas fa-shopping-cart"></i> &nbsp;ADD TO
                                    CART</button>
                            </form>
                        @else
                            <button class="btn btn-danger">OUT OF STOCK</button>
                        @endif
                    @else
                        <form action="{{ route('front.addToCart', $product->id) }}" method="post">
                            @csrf
                            <button class="btn btn-dark"><i class="fas fa-shopping-cart"></i> &nbsp;ADD TO CART</button>
                        </form>
                    @endif
                </div>
            </div>

            <div class="col-md-12 mt-5">
                <div class="bg-light p-4">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                                data-bs-target="#description" type="button" role="tab" aria-controls="description"
                                aria-selected="true">Description</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="shipping-tab" data-bs-toggle="tab" data-bs-target="#shipping"
                                type="button" role="tab" aria-controls="shipping" aria-selected="false">Shipping &
                                Returns</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews"
                                type="button" role="tab" aria-controls="reviews"
                                aria-selected="false">Reviews</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="description" role="tabpanel"
                            aria-labelledby="description-tab">
                            <p>{!! $product->description !!}</p>
                        </div>
                        <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
                            <p>{!! $product->shipping_returns !!}</p>
                        </div>
                        <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                            <div class="col-md-8">
                                <div class="row">
                                    <h3 class="h4 pb-3">Write a Review</h3>
                                    <form action="{{ route('shop.saveRating', $product->id) }}" method="POST">
                                        @csrf
                                        <div class="form-group col-md-6 mb-3">
                                            <label for="name">Name</label>
                                            <input type="text"
                                                class="form-control @error('name') is-invalid @enderror"
                                                name="username" id="name" placeholder="Name">
                                            <span class="text-danger1">
                                                @error('username')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                        <div class="form-group col-md-6 mb-3">
                                            <label for="email">Email</label>
                                            <input type="text"
                                                class="form-control @error('email') is-invalid @enderror"
                                                name="email" id="email" placeholder="Email">
                                            <span class="text-danger1">
                                                @error('email')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="rating">Rating</label>
                                            <br>
                                            <div class="rating" style="width: 10rem">
                                                <input id="rating-5" type="radio" name="rating"
                                                    value="5" /><label for="rating-5"><i
                                                        class="fas fa-3x fa-star"></i></label>
                                                <input id="rating-4" type="radio" name="rating"
                                                    value="4" /><label for="rating-4"><i
                                                        class="fas fa-3x fa-star"></i></label>
                                                <input id="rating-3" type="radio" name="rating"
                                                    value="3" /><label for="rating-3"><i
                                                        class="fas fa-3x fa-star"></i></label>
                                                <input id="rating-2" type="radio" name="rating"
                                                    value="2" /><label for="rating-2"><i
                                                        class="fas fa-3x fa-star"></i></label>
                                                <input id="rating-1" type="radio" name="rating"
                                                    value="1" /><label for="rating-1"><i
                                                        class="fas fa-3x fa-star"></i></label>
                                            </div>
                                            <span class="text-danger1">
                                                @error('rating')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="">How was your overall experience?</label>
                                            <textarea name="comment" id="review" class="form-control @error('comment') is-invalid @enderror" cols="30"
                                                rows="10" placeholder="How was your overall experience?"></textarea>
                                            <span class="text-danger1">
                                                @error('comment')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                        <div>
                                            <button class="btn btn-dark">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-12 mt-5">
                                <div class="overall-rating mb-3">
                                    <div class="d-flex">
                                        <h1 class="h3 pe-3">{{ $avgRating }}</h1>
                                        <div class="star-rating mt-2" title="">
                                            <div class="back-stars">
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>

                                                <div class="front-stars" style="width: {{ $avgRatingPer }}%">
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pt-2 ps-2">({{ $product->product_ratings_count }} Reviews)</div>
                                    </div>
                                </div>
                                @if ($product->product_ratings->isNotEmpty())
                                    @foreach ($product->product_ratings as $rating)
                                    @php
                                        $ratingper = ($rating->rating*100)/5;
                                    @endphp
                                    <div class="rating-group mb-4">
                                        <span> <strong> {{ $rating->username }} </strong></span>
                                        <div class="star-rating mt-2" title="%">
                                            <div class="back-stars">
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
    
                                                <div class="front-stars" style="width: {{  $ratingper }}%">
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="my-3">
                                            <p>  {{ $rating->comment }} </p>
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                                

                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if (!empty($relatedProducts))
    <section class="pt-5 section-8">
        <div class="container">
            <div class="section-title">
                <h2>Related Products</h2>
            </div>
            <div class="col-md-12">
                <div id="related-products" class="d-flex flex-wrap gap-3">
                    @foreach ($relatedProducts as $relatedPro)
                        <div class="card product-card" style="width: 18rem;">
                            <div class="product-image position-relative">
                                <a href="{{ route('front.product', $relatedPro->slug) }}" class="product-img">
                                    <img class="card-img-top"
                                        src="{{ asset('storage/' . $relatedPro->images->first()->image) }}"
                                        alt="">
                                </a>
                                <a class="whishlist" href="222"><i class="far fa-heart"></i></a>
                                <div class="product-action">
                                    @if ($relatedPro->track_qty == 'Yes')
                                        @if ($relatedPro->qty > 0)
                                            <form action="{{ route('front.addToCart', $relatedPro->id) }}"
                                                method="post">
                                                @csrf
                                                <button class="btn btn-dark"><i class="fas fa-shopping-cart"></i>
                                                    &nbsp;ADD TO CART</button>
                                            </form>
                                        @else
                                            <button class="btn btn-danger">OUT OF STOCK</button>
                                        @endif
                                    @else
                                        <form action="{{ route('front.addToCart', $relatedPro->id) }}"
                                            method="post">
                                            @csrf
                                            <button class="btn btn-dark"><i class="fas fa-shopping-cart"></i>
                                                &nbsp;ADD TO CART</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body text-center">
                                <a class="h6 link"
                                    href="{{ route('front.product', $relatedPro->slug) }}">{{ $relatedPro->title }}</a>
                                <div class="price mt-2">
                                    <span class="h5"><strong>${{ $relatedPro->price }}</strong></span>
                                    <span
                                        class="h6 text-underline"><del>${{ $relatedPro->compare_price }}</del></span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif
@include('front.footer')

<style>
    .rating {
        direction: rtl;
        unicode-bidi: bidi-override;
        color: #ddd;
        /* Personal choice */
        font-size: 8px;
        margin-left: -15px;
    }

    .rating input {
        display: none;
    }

    .rating label:hover,
    .rating label:hover~label,
    .rating input:checked+label,
    .rating input:checked+label~label {
        color: #ffc107;
        /* Personal color choice. Lifted from Bootstrap 4 */
        font-size: 8px;
    }

    .front-stars,
    .back-stars,
    .star-rating {
        display: flex;
    }

    .star-rating {
        align-items: left;
        font-size: 1em;
        justify-content: left;
        margin-left: -5px;
    }

    .back-stars {
        color: #CCC;
        position: relative;
    }

    .front-stars {
        color: #FFBC0B;
        overflow: hidden;
        position: absolute;
        top: 0;
        transition: all 0.5s;
    }

    .percent {
        color: #bb5252;
        font-size: 1.5em;
    }

    .text-danger1 {
        color: #dc3545 !important;
        /* Default Bootstrap color */
        font-size: 0.875rem;
        /* Adjust font size for better visibility */
    }
</style>
