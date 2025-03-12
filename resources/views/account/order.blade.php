@extends('front.layout.app')

@include('front.yourcart')

@include('front.mobilesearch')

@include('front.header')

<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{ route('account.profile', ['id' => Auth::id()]) }}">My Account</a></li>
                <li class="breadcrumb-item">Settings</li>
            </ol>
        </div>
    </div>
</section>



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
                        <h2 class="h5 mb-0 pt-2 pb-2">My Orders</h2>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table">
                                <thead> 
                                    <tr>
                                        <th>Orders #</th>
                                        <th>Date Purchased</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @foreach ($orders as $order)
                                    <tr>
                                        <td>
                                            <a href="{{ route('account.orderdetail',$order->id) }}">{{ $order->id }}</a>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d M, Y') }}</td>
                                        <td>
                                            @if ($order->status == 'pending')
                                                <span class="badge bg-danger">Pending</span>
                                            @elseif ($order->status == 'shipped')
                                                <span class="badge bg-info">Shipped</span>
                                            @elseif ($order->status == 'cancelled')
                                                <span class="badge bg-danger">Cancelled</span>
                                            @else
                                                <span class="badge bg-success">Delivered</span>
                                            @endif                                                                                      
                                        </td>
                                        <td>${{ number_format($order->grand_total,2) }}</td>
                                    </tr>
                                    @endforeach                                                                                                         
                                </tbody>
                            </table>
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
