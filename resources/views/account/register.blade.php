@extends('front.layout.app')

@include('front.yourcart')

@include('front.mobilesearch')

@include('front.header')


<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.home') }}">Home</a></li>
                <li class="breadcrumb-item">Register</li>
            </ol>
        </div>
    </div>
</section>

<section class="section-10 py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-4">
                        <h4 class="modal-title text-center mb-4">Register Now</h4>
                        <form action="{{ route('account.registersave',$product->id) }}" method="post">
                            @csrf
                            <div class="form-group mb-3">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Name" id="name" name="name">
                                <span class="text-danger1">
                                    @error('name')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group mb-3">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Email" id="email" name="email">
                                <span class="text-danger1">
                                    @error('email')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group mb-3">
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="Phone" id="phone" name="phone">
                                <span class="text-danger1">
                                    @error('phone')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group mb-3">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" id="password" name="password">
                                <span class="text-danger1">
                                    @error('password')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group mb-3">
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirm Password" id="cpassword" name="password_confirmation">
                                <span class="text-danger1">
                                    @error('password_confirmation')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group text-end mb-3">
                                <a href="#" class="forgot-link small text-decoration-none">Forgot Password?</a>
                            </div>
                            <button type="submit" class="btn btn-dark btn-block w-100">Register</button>
                        </form>
                        <div class="text-center small mt-3">
                            Already have an account? <a href="{{ route('login') }}"
                                class="text-primary text-decoration-none">Login Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('front.footer')

<style>
    .text-danger1 {
    color: #dc3545 !important; /* Default Bootstrap color */
    font-size: 0.875rem; /* Adjust font size for better visibility */
}
</style>