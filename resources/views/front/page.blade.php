@extends('front.layout.app')

@include('front.yourcart')

@include('front.mobilesearch')

@include('front.header')

<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.home') }}">Home</a></li>
                <li class="breadcrumb-item">{{ $page->name }}</li>
            </ol>
        </div>
    </div>
</section>

@if ($page->slug == 'contact-us')
    <section>
        <div class="container-fluid">

            <div class="bg-secondary py-5 my-5 rounded-5"
                style="background: url('images/bg-leaves-img-pattern.png') no-repeat;">
                <div class="container my-5">
                    <div class="row">
                        <div class="col-md-6 p-5">
                            <div class="section-header">
                                <h2 class="section-title display-4">Get <span class="text-primary">25% Discount</span>
                                    on your first purchase</h2>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Dictumst amet, metus, sit massa
                                posuere maecenas. At tellus ut nunc amet vel egestas.</p>
                        </div>
                        <div class="col-md-6 p-5">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            <form action="{{ route('contact.send') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control form-control-lg" name="name"
                                        id="name" placeholder="Name">
                                        <span class="text-danger1">
                                            @error('name')
                                                {{$message}}
                                            @enderror
                                        </span>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control form-control-lg" name="email"
                                        id="email" placeholder="abc@mail.com">
                                        <span class="text-danger1">
                                            @error('email')
                                                {{$message}}
                                            @enderror
                                        </span>
                                </div>
                                <div class="mb-3">
                                    <label for="subject" class="form-label">Subject</label>
                                    <input type="text" class="form-control form-control-lg" name="subject"
                                        id="subject" placeholder="Subject">
                                        <span class="text-danger1">
                                            @error('subject')
                                                {{$message}}
                                            @enderror
                                        </span>
                                </div>
                                <div class="mb-3">
                                    <label for="message" class="form-label">Message</label>
                                    <textarea name="message" id="message" cols="30" rows="5" class="form-control form-control-lg"></textarea>
                                    <span class="text-danger1">
                                        @error('message')
                                            {{$message}}
                                        @enderror
                                    </span>
                                </div>
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-dark btn-lg">Send Message</button>
                                </div>
                            </form>


                        </div>

                    </div>

                </div>
            </div>

        </div>
    </section>
@else
    <section class=" section-10 mb-3 ">
        <div class="container content">
            <h1 class="my-3">{{ $page->name }}</h1>
            {!! $page->content !!}
        </div>
    </section>
@endif



@include('front.footer')
<style>
    .content {
        background-color: #f8f8f8
    }


.text-danger1 {
    color: #dc3545 !important; /* Default Bootstrap color */
    font-size: 0.875rem; /* Adjust font size for better visibility */
}
</style>
