@extends('front.layout.app')

@include('front.yourcart')

@include('front.mobilesearch')

@include('front.header')

<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.home') }}">Home</a></li>
                <li class="breadcrumb-item">Forgot Password</li>
            </ol>
        </div>
    </div>
</section>



<section class="section-10 py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-4">
                        @if (Session::has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ Session::get('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    @if (Session::has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ Session::get('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                        <h4 class="modal-title text-center mb-4">Forgot Password</h4>
                        <form action="{{ route('processresetpassword') }}" method="post">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="form-group mb-3">
                                <label for="name">New Password</label>
                                <input type="password" name="new_password" value="{{ old('new_password') }}"
                                    placeholder="New Password"
                                    class="form-control @error('newpassword') is-invalid @enderror">
                                <span class="text-danger1">
                                    @error('new_password')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="form-group mb-3">
                                <label for="name">Confirm Password</label>
                                <input type="password" name="confirm_password" value="{{ old('confirm_password') }}"
                                    placeholder="New Password"
                                    class="form-control @error('confirm_password') is-invalid @enderror">
                                <span class="text-danger1">
                                    @error('confirm_password')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            
                            
                            <button type="submit" class="btn btn-dark btn-lg w-100">Submit</button>
                        </form>
                        <div class="text-center mt-3 small">
                            <a href="{{ route('login') }}"
                                class="text-primary text-decoration-none">Login</a>
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
        color: #dc3545 !important;
        font-size: 0.875rem;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

