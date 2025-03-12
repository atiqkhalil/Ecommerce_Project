<section class="py-5">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">

                <div class="bootstrap-tabs product-tabs">
                    <div class="tabs-header d-flex justify-content-between border-bottom my-5">
                        <h3>Just Arrived Products</h3>
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                {{-- <a href="#" class="nav-link text-uppercase fs-6 active" id="nav-all-tab"
                                    data-bs-toggle="tab" data-bs-target="#nav-all">All</a>
                                <a href="#" class="nav-link text-uppercase fs-6" id="nav-fruits-tab"
                                    data-bs-toggle="tab" data-bs-target="#nav-fruits">Fruits & Veges</a>
                                <a href="#" class="nav-link text-uppercase fs-6" id="nav-juices-tab"
                                    data-bs-toggle="tab" data-bs-target="#nav-juices">Juices</a> --}}
                            </div>
                        </nav>
                    </div>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-all" role="tabpanel"
                            aria-labelledby="nav-all-tab">

                            <div
                                class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                                @foreach ($justarrivedproducts as $product)
                                    <div class="col">
                                        <div id="product-page">
                                            <div class="product-item">
                                                <form action="{{ route('wishlist', $product->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn-wishlist">
                                                      <svg width="24" height="24">
                                                          <use xlink:href="#heart"></use>
                                                      </svg>
                                                  </button>
                                                </form>
                                                <figure>
                                                    <a href="{{ route('front.product',$product->slug) }}" title="Product Title">
                                                        <img src="{{ asset('storage/' . $product->images->first()->image) }}" class="tab-image">
                                                    </a>
                                                </figure>
                                                <h3>{{ $product->title }}</h3>
                                                <span class="qty">{{ $product->qty }} <span class="text-lowercase">left in Stock</span></span>
                                                <div>
                                                    <span class="price d-inline">${{ $product->price }}</span>
                                                    <span class="text-decoration-line-through d-inline">${{ $product->compare_price }}</span>
                                                </div>
                                                <div class="mt-auto">
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
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                            <!-- / product-grid -->

                        </div>



                    </div>

                </div>
            </div>

        </div>
    </div>
    </div>
</section>

<style>
    .col{
      margin-bottom: 20px; 
    }
    #product-page .product-item {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    border: 1px solid #ddd;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    text-align: center;
    height: 100%;    
}

#product-page .product-item figure {
    margin: 0;
    padding: 0;
    max-height: 150px;
    overflow: hidden;
    display: flex;
    justify-content: center;
    align-items: center;
}

#product-page .product-item img {
    max-height: 100%;
    max-width: 100%;
    object-fit: cover;
}

#product-page .product-title {
    font-size: 1.2rem;
    margin: 10px 0;
    min-height: 50px;
}

#product-page .qty {
    font-size: 0.9rem;
    margin-bottom: 10px;
}

#product-page .product-price {
    margin: 10px 0;
}

#product-page .product-item .btn {
    margin-top: auto;
    width: 100%;
}

#product-page .product-item .btn:hover {
    background-color: #ffc43f;
   color: black;
}

  </style>

  
