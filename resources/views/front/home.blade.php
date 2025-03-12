@extends('front.layout.app')


 @include('front.yourcart')
    
   @include('front.mobilesearch')

   @include('front.header') 

    
     @include('front.herosection') 

     @include('front.categories')


    {{-- @include('front.newlyarrivedbrand') --}}


   @include('front.featuredproduct')

   @include('front.adsproduct')

   @include('front.email')

   {{-- @include('front.popularproducts') --}}

    @include('front.justarrived')

   {{-- @include('front.blog')

   @include('front.peoplelooking')  --}}

    @include('front.footer') 

   