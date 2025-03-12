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



            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h2 class="h5 mb-0 pt-2 pb-2">Change Password</h2>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('account.updatepassword') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="mb-3">
                                    <label for="name">Old Password</label>
                                    <input type="password" name="old_password" value="{{ old('old_password') }}"
                                        placeholder="Old Password"
                                        class="form-control @error('oldpassword') is-invalid @enderror">
                                    <span class="text-danger1">
                                        @error('old_password')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mb-3">
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
                                <div class="mb-3">
                                    <label for="name">Confirm Password</label>
                                    <input type="password" name="confirm_password" value="{{ old('confirm_password') }}"
                                        placeholder="Confirm Password"
                                        class="form-control @error('confirm_password') is-invalid @enderror">
                                    <span class="text-danger1">
                                        @error('confirm_password')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="d-flex">
                                    <button class="btn btn-dark">Save</button>
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
