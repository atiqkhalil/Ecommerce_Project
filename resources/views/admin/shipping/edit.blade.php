@extends('admin.dashboard')

@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Shipping Management</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('shipping.create') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">

        @include('admin.message')

        <!-- Default box -->
        <form action="{{ route('shipping.editsave',$shippingCharge->id) }}" method="post" >
            @csrf          
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <select name="country" id="country" class="form-control">
                                        <option value="">Select a Country</option>
                                        @foreach ($countries as $country)
                                            <option {{ ($shippingCharge->country_id == $country->id) ? 'selected' : '' }} value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                        <option {{ ($shippingCharge->country_id == 'rest_of_world') ? 'selected' : '' }} value="rest_of_world">Rest of the World</option>
                                    </select>
                                </div>
                            
                            </div>

                            <div class="col-md-4">
                                <input type="text" name="amount" id="amount" value="{{ $shippingCharge->amount }}" class="form-control" placeholder="Amount">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
        </form>
        <!-- /.card -->
        
    </section>
    <!-- /.content -->
    </div>
@endsection

