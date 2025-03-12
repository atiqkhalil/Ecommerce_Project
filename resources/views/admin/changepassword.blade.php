@extends('admin.dashboard')

@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Change Password </h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>

    @include('admin.message')
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <form action="{{ route('account.adminupdatepassword') }}" method="post" >
            @csrf
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Old Password</label>
                                    <input type="password" name="old_password" value="{{ old('old_password') }}"
                                        placeholder="Old Password"
                                        class="form-control @error('oldpassword') is-invalid @enderror"> </div>
                                    <span class="text-danger1">
                                        @error('old_password')
                                            {{ $message }}
                                        @enderror
                                    </span>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">New Password</label>
                                    <input type="password" name="new_password" value="{{ old('new_password') }}"
                                        placeholder="New Password"
                                        class="form-control @error('newpassword') is-invalid @enderror"> </div>
                                    <span class="text-danger1">
                                        @error('new_password')
                                            {{ $message }}
                                        @enderror
                                    </span>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Confirm Password</label>
                                    <input type="password" name="confirm_password" value="{{ old('confirm_password') }}"
                                        placeholder="Confirm Password"
                                        class="form-control @error('confirm_password') is-invalid @enderror"> </div>
                                    <span class="text-danger1">
                                        @error('confirm_password')
                                            {{ $message }}
                                        @enderror
                                    </span>
                            </div>
                           
                        </div>
                    </div>
                </div>

                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </div>
        </form>
        <!-- /.card -->
    </section>
    <!-- /.content -->
    </div>
@endsection

<style>
    .text-danger1 {
        color: #dc3545 !important;
        font-size: 0.875rem;
    }
</style>