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
                <li class="breadcrumb-item">Cart</li>
            </ol>
        </div>
    </div>
</section>

<section class="section-9 ">
    <div class="container">
        <div class="row">
            @if (Session::has('success'))
            <div class="col-md-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ Session::get('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
            </div>
            @endif

            @if (Session::has('error'))
            <div class="col-md-12">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ Session::get('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
            </div>
            @endif

            @if (Cart::count() > 0)
                 <!-- Cart Table -->
            <div class="col-md-8">
                <div class="table-responsive">
                    <table class="table" id="cart">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Remove</th>
                            </tr>
                            <tr>
                                <td colspan="5" style="border-top: 2px solid #0b0b0b;"></td>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Repeat this block for each product -->
                            @foreach ($cartContents as $cartContent)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if (!empty($cartContent->options['productImage']))
                                            <img src="{{ asset('storage/' . $cartContent->options['productImage']) }}" alt="Product">
                                        @else
                                            <img src="{{ asset('admin-assets/img/default-150x150.png') }}" alt="Product">
                                        @endif                                       
                                            <h2>{{ $cartContent->name }}</h2>
                                        </div>
                                    </td>
                                    <td>${{ $cartContent->price }}</td>
                                    <td>
                                        <div class="input-group quantity mx-auto">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-dark btn-minus sub" data-id = "{{ $cartContent->rowId }}">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                            <input type="text" class="form-control form-control-sm text-center"
                                                value="{{ $cartContent->qty }}">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-dark btn-plus add" data-id = "{{ $cartContent->rowId }}">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>${{ $cartContent->price*$cartContent->qty }}</td>
                                    <td>
                                        <form action="{{ route('front.deletecart') }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="rowId" value="{{ $cartContent->rowId }}">
                                            <button class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>
                                        </form>
                                        
                                    </td>
                                </tr>
                            @endforeach

                            <!-- End of product block -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Cart Summary -->
            <div class="col-md-4">
                <div class="card cart-summery">
                    
                    <div class="card-body">
                        <div class="sub-title">
                            <h2>Cart Summary</h2>
                        </div>
                        <div class="d-flex justify-content-between pb-2">
                            <div>Subtotal</div>
                            <div>${{ Cart::subtotal(); }}</div>
                        </div>
                        
                        <div class="pt-2">
                            <a href="{{ route('front.checkout') }}" class="btn-dark btn btn-block w-100">Proceed to Checkout</a>
                        </div>
                    </div>
                </div>

                <!-- Coupon Code -->
                {{-- <div class="input-group apply-coupan mt-4">
                    <input type="text" placeholder="Coupon Code" class="form-control">
                    <button class="btn btn-dark" type="button" id="button-addon2">Apply Coupon</button>
                </div> --}}
            </div>
            @else
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body d-flex justify-content-center align-center">
                            <h4>Your Cart is empty!</h4>
                        </div>
                    </div>
                </div>
            @endif
            
           
        </div>
    </div>
</section>




@include('front.footer')

@section('customjs')
<script>
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

    $('.add').click(function(){
        var qtyElement = $(this).parent().prev(); // Qty Input
        var qtyValue = parseInt(qtyElement.val());
        if (qtyValue < 10) {
            var rowId = $(this).data('id');
            qtyElement.val(qtyValue+1);
            var newQty = qtyElement.val();
            updateCart(rowId,newQty)
        }            
    });
    
    $('.sub').click(function(){
        var qtyElement = $(this).parent().next(); 
        var qtyValue = parseInt(qtyElement.val());
        if (qtyValue > 1) {
            qtyElement.val(qtyValue-1);

            var rowId = $(this).data('id');
            var newQty = qtyElement.val();
            updateCart(rowId,newQty)
        }        
    });

    function updateCart(rowId,qty){
        $.ajax({
            url : '{{ route('front.updateCart') }}',
            type: 'post',
            data: {_token: csrfToken,rowId:rowId,qty:qty},
            dataType: 'json',
            success:function(response){
                if(response.status == true){
                    window.location.href = '{{ route('front.cart') }}';
                }
            }
        });
    }
    </script>
    
@endsection

<style>
    /* Cart Table */
    #cart {
        background-color: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }

    #cart th {
        background-color: #ffc544;
        font-weight: bold;
        text-align: center;
        padding: 1rem;
        color: black
    }

    #cart td {
        text-align: center;
        vertical-align: middle;
        padding: 1rem;
    }

    #cart img {
        width: 50px;
        height: 50px;
        margin-right: 10px;
        border-radius: 4px;
    }

    #cart h2 {
        font-size: 16px;
        font-weight: bold;
        margin: 0;
    }

    /* Buttons */
    .btn-dark {
        background-color: #04203f;
        border: none;
    }

    .btn-dark:hover {
        background-color: #23272b;
    }

    .btn-danger {
        background-color: #dc3545;
        border: none;
        transition: background-color 0.3s ease;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    /* Cart Summary Card */
    .cart-summery {
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        border: none;
        border-radius: 8px;
    }

    .cart-summery .sub-title h2 {
        font-size: 18px;
        margin: 0;
        padding: 10px;
        text-align: center;
        background-color: #f8f9fa;
        font-weight: bold;
    }

    .cart-summery .summery-end {
        font-weight: bold;
    }

    .cart-summery .btn-dark {
        font-size: 16px;
        background-color: #04203f;
    }

    /* Coupon Code */
    .apply-coupan {
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    .apply-coupan input {
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
    }

    .apply-coupan button {
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
        background-color: #04203f;
    }
</style>
