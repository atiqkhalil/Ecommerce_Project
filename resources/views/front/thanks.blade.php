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
            </ol>
        </div>
    </div>
</section>

<section class="section-9 ">
    <div class="container">
        <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body d-flex justify-content-center align-center">
                            <h4>✅ Thank You! Your Order Placed Successfully. And Your Order Id is: {{ $id }}</h4>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</section>




@include('front.footer')




