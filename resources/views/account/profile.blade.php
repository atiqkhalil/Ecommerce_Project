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

<div class="row justify-content-center">
    <div class="col-9">
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
    </div>
</div>

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
                        <h2 class="h5 mb-0 pt-2 pb-2">Personal Information</h2>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('account.updateprofile', $user->id) }}" method="POST">
                            @csrf
                            <div class="row">
                                <!-- Name Field -->
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" name="name" id="name" value="{{ $user->name }}"
                                        placeholder="Enter Your Name" class="form-control @error('name') is-invalid @enderror">
                                        <span class="text-danger1">
                                            @error('name')
                                                {{$message}}
                                            @enderror
                                        </span>
                                </div>

                                <!-- Email Field -->
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" value="{{ $user->email }}" id="email"
                                        placeholder="Enter Your Email" class="form-control @error('email') is-invalid @enderror">
                                        <span class="text-danger1">
                                            @error('email')
                                                {{$message}}
                                            @enderror
                                        </span>
                                </div>

                                <!-- Phone Field -->
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" name="phone" value="{{ $user->phone }}" id="phone"
                                        placeholder="Enter Your Phone" class="form-control @error('phone') is-invalid @enderror">
                                        <span class="text-danger1">
                                            @error('phone')
                                                {{$message}}
                                            @enderror
                                        </span>
                                </div>

                                <!-- Address Field -->
                                <div class="col-md-12 mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea name="address" id="address" class="form-control @error('name') is-invalid @enderror" rows="4" placeholder="Enter Your Address">{{ $user->customerAddress ? $user->customerAddress->address : '' }}</textarea>
                                </div>

                                <!-- Update Button -->
                                <div class="col-md-12">
                                    <button type="submit"
                                        class="btn bg-primary text-dark btn-dark btn-lg">Update</button>
                                </div>
                            </div>
                        </form>
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


