@extends('admin.dashboard')

@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Update Coupon Code</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('discountcode.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>

        @include('admin.message')
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <form action="{{ route('discountcode.update',$coupondetails->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="code">Code</label>
                                    <input type="text" name="code" id="code"
                                        class="form-control @error('code') is-invalid @enderror" value="{{ $coupondetails->code }}"
                                        placeholder="Coupn Code">
                                </div>
                                <span class="text-danger">
                                    @error('code')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name"
                                        class="form-control" value="{{ $coupondetails->name }}"
                                        placeholder="Coupn Code Name">
                                </div>
                               
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="max_uses">Max Uses</label>
                                    <input type="number" name="max_uses" id="max_uses"
                                    class="form-control " value="{{ $coupondetails->max_uses }}"
                                    placeholder="Max Uses">
                                </div>
                                
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="max_uses_user">Max Uses User</label>
                                    <input type="number" name="max_uses_user" id="max_uses_user"
                                    class="form-control " value="{{ $coupondetails->max_uses_user }}"
                                    placeholder="Max Uses User">
                                </div>
                              
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="type">Type</label>
                                    <select name="type" id="type" class="form-control">
                                        <option value="percent" {{ old('type', $coupondetails->type) == 'percent' ? 'selected' : '' }}>Percent</option>
                                        <option value="fixed" {{ old('type', $coupondetails->type) == 'fixed' ? 'selected' : '' }}>Fixed</option>
                                    </select>                                    
                                </div>
                                <span class="text-danger">
                                    @error('type')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="discount_amount">Discount Amount</label>
                                    <input type="number" name="discount_amount" id="discount_amount"
                                    class="form-control @error('discount_amount') is-invalid @enderror" value="{{ $coupondetails->discount_amount }}"
                                    placeholder="Discount Amount">
                                </div>
                                <span class="text-danger">
                                    @error('discount_amount')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="min_amount">Minimum Amount</label>
                                    <input type="number" name="min_amount" id="min_amount"
                                    class="form-control" value="{{ $coupondetails->min_amount }}"
                                    placeholder="Minimum Amount">
                                </div>
                               
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1" {{ old('status', $coupondetails->status) == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status', $coupondetails->status) == 0 ? 'selected' : '' }}>Block</option>
                                    </select>                                    
                                </div>
                                <span class="text-danger">
                                    @error('status')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="starts_at">Starts_at</label>
                                    <input type="text" autocomplete="off" name="starts_at" id="starts_at"
                                    class="form-control @error('starts_at') is-invalid @enderror" value="{{ $coupondetails->starts_at }}"
                                    placeholder="starts_at">
                                </div>
                                <span class="text-danger">
                                    @error('starts_at')
                                        {{ $message }}
                                    @enderror
                                </span>
                                
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="expires_at">Expires_at</label>
                                    <input type="text" autocomplete="off" name="expires_at" id="expires_at"
                                    class="form-control @error('expires_at') is-invalid @enderror" value="{{ $coupondetails->expires_at }}"
                                    placeholder="expires_at">
                                </div>
                                <span class="text-danger">
                                    @error('expires_at')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="description">Description</label>
                                    <textarea name="description" class="form-control" id="description" cols="30" rows="5">{{ old('description', $coupondetails->description) }}</textarea>
                                </div>
                               
                            </div>

                        </div>
                    </div>
                </div>

                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="#" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </div>
        </form>
        <!-- /.card -->
    </section>
    <!-- /.content -->
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $('#starts_at').datetimepicker({
            // options here
            format:'Y-m-d H:i:s',
        });
    });

    $(document).ready(function(){
        $('#expires_at').datetimepicker({
            // options here
            format:'Y-m-d H:i:s',
        });
    });
</script>
@endsection


