@extends('admin.dashboard')

@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Order: #{{ $order->id }}</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('orders.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9">
                    @include('admin.message')
                    <div class="card">
                        <div class="card-header pt-3">
                            <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col">
                                    <h1 class="h5 mb-3">Shipping Address</h1>
                                    <address>
                                        <strong>{{ $order->first_name . ' ' . $order->last_name }}</strong><br>
                                        {{ $order->address }}<br>
                                        {{ $order->city }}, {{ $order->zip }}, {{ $order->country->name }}<br>
                                        Phone: {{ $order->mobile }}<br>
                                        Email: {{ $order->email }}
                                    </address>
                                    <strong>Shipped Date: </strong> <br>
                                    @if (!empty($order->shipped_date))
                                        {{ \Carbon\Carbon::parse($order->shipped_date)->format('d M,Y') }}
                                    @else
                                        N/A
                                    @endif
                                </div>



                                <div class="col-sm-4 invoice-col">
                                    {{-- <b>Invoice #007612</b><br>
                                <br> --}}
                                    <b>Order ID:</b> {{ $order->id }}<br>
                                    <b>Total:</b> ${{ number_format($order->grand_total, 2) }}<br>
                                    <b>Status:</b>
                                    @if ($order->status == 'pending')
                                        <span class="text-danger">Pending</span>
                                    @elseif ($order->status == 'shipped')
                                        <span class="text-info">Shipped</span>
                                    @elseif ($order->status == 'cancelled')
                                        <span class="text-danger">Cancelled</span>
                                    @else
                                        <span class="text-success">Delivered</span>
                                    @endif
                                    <br>
                                </div>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-3">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th width="100">Price</th>
                                        <th width="100">Qty</th>
                                        <th width="100">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orderItems as $orderItem)
                                        <tr>
                                            <td>{{ $orderItem->name }}</td>
                                            <td>${{ number_format($orderItem->price, 2) }}</td>
                                            <td>{{ $orderItem->qty }}</td>
                                            <td>${{ number_format($orderItem->total, 2) }}</td>
                                        </tr>
                                    @endforeach


                                    <tr>
                                        <th colspan="3" class="text-right">Subtotal:</th>
                                        <td>${{ number_format($order->subtotal, 2) }}</td>
                                    </tr>

                                    <tr>
                                        <th colspan="3" class="text-right">Shipping:</th>
                                        <td>${{ number_format($order->shipping, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th colspan="3" class="text-right">Grand Total:</th>
                                        <td>${{ number_format($order->grand_total, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <form action="" method="post" name="changeOrderStatusForm" id="changeOrderStatusForm">
                            @csrf
                            <div class="card-body">
                                <h2 class="h4 mb-3">Order Status</h2>
                                <div class="mb-3">
                                    <select name="status" id="status" class="form-control">
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>
                                            Shipped</option>
                                        <option value="deliverd" {{ $order->status == 'deliverd' ? 'selected' : '' }}>
                                            Delivered</option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                            Cancelled</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="shippeddate">Shipped Date</label>
                                    <input type="text" placeholder="Shipped Date" value="{{ $order->shipped_date }}" id="shipped_date"
                                        name="shipped_date" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    {{-- <div class="card">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Send Inovice Email</h2>
                            <div class="mb-3">
                                <select name="status" id="status" class="form-control">
                                    <option value="">Customer</option>
                                    <option value="">Admin</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary">Send</button>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#shipped_date').datetimepicker({
                // options here
                format: 'Y-m-d H:i:s',
            });
        });

        $("#changeOrderStatusForm").submit(function(event) {
            event.preventDefault();

            $.ajax({
                url: '{{ route('orders.changeOrderStatus', $order->id) }}',
                type: 'post',
                data: $(this).serializeArray(),
                dataType: 'json',
                success: function(response) {
                    window.location.href = "{{ route('orders.detail', $order->id) }}";
                }
            });
        })
    </script>
@endsection
