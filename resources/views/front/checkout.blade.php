@extends('front.layout.app')

@include('front.yourcart')

@include('front.mobilesearch')

@include('front.header')


<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.home') }}">Home</a></li>
                <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.shop') }}">Shop</a></li>
                <li class="breadcrumb-item">Checkout</li>
            </ol>
        </div>
    </div>
</section>

<section class="section-9 pt-4">
    <div class="container">
        <div class="row">
            <!-- Shipping Address Section -->
            <div class="col-md-8">
                <div class="sub-title mb-4">
                    <h2 class="h4">Shipping Address</h2>
                </div>
                <div class="container">
                    <div class="row d-flex flex-wrap gap-4">
                        <!-- Left Column: Checkout Form -->
                        <div class="flex-grow-1" style="flex: 2; min-width: 60%;">
                            <div class="card shadow-lg border-0">
                                <div class="card-body">
                                    <h4 class="mb-3">Checkout Form</h4>
                                    <form action="{{ route('front.processCheckout') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="first_name" class="form-label">First Name</label>
                                            <input type="text" name="first_name" id="first_name"
                                                class="form-control @error('first_name') is-invalid @enderror"
                                                placeholder="Enter First Name">
                                            <span class="text-danger1">
                                                @error('first_name')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="last_name" class="form-label">Last Name</label>
                                            <input type="text" name="last_name" id="last_name"
                                                class="form-control @error('last_name') is-invalid @enderror"
                                                placeholder="Enter Last Name">
                                            <span class="text-danger1">
                                                @error('last_name')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" name="email" id="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                placeholder="Enter Email">
                                            <span class="text-danger1">
                                                @error('email')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="country" class="form-label">Country</label>
                                            <select name="country" id="country" class="form-select">
                                                <option value="">Select a Country</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger1">
                                                @error('country')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="address" class="form-label">Address</label>
                                            <textarea name="address" id="address" rows="3" class="form-control @error('address') is-invalid @enderror"
                                                placeholder="Enter Address"></textarea>
                                            <span class="text-danger1">
                                                @error('address')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="apartment" class="form-label">Apartment, Suite, etc.
                                                (Optional)</label>
                                            <input type="text" name="apartment" id="apartment" class="form-control"
                                                placeholder="Enter Apartment or Suite">

                                        </div>

                                        <div class="mb-3">
                                            <label for="city" class="form-label">City</label>
                                            <input type="text" name="city" id="city"
                                                class="form-control @error('city') is-invalid @enderror"
                                                placeholder="Enter City">
                                            <span class="text-danger1">
                                                @error('city')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>

                                        <div class="mb-3">
                                            <label for="state" class="form-label">State</label>
                                            <input type="text" name="state" id="state"
                                                class="form-control @error('state') is-invalid @enderror"
                                                placeholder="Enter State">
                                            <span class="text-danger1">
                                                @error('state')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>

                                        <div class="mb-3">
                                            <label for="zip" class="form-label">Zip Code</label>
                                            <input type="text" name="zip" id="zip"
                                                class="form-control @error('zip') is-invalid @enderror"
                                                placeholder="Enter Zip Code">
                                            <span class="text-danger1">
                                                @error('zip')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>

                                        <div class="mb-3">
                                            <label for="mobile" class="form-label">Mobile Number</label>
                                            <input type="text" name="mobile" id="mobile"
                                                class="form-control @error('mobile') is-invalid @enderror"
                                                placeholder="Enter Mobile Number">
                                            <span class="text-danger1">
                                                @error('mobile')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>

                                        <div class="mb-3">
                                            <label for="order_notes" class="form-label">Order Notes (Optional)</label>
                                            <textarea name="order_notes" id="order_notes" rows="2" class="form-control" placeholder="Enter Order Notes"></textarea>

                                        </div>



                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Order Summary, Coupon, Payment -->
                        <div class="flex-grow-1" style="flex: 1; min-width: 35%;">
                            <div class="d-flex flex-column">

                                <!-- Order Summary -->
                                <div class="card shadow-lg border-0 mb-4">
                                    <div class="card-body">
                                        <h4 class="mb-3">Order Summary</h4>
                                        @foreach (Cart::content() as $items)
                                            <div class="d-flex justify-content-between pb-2">
                                                <div class="h6">{{ $items->name }} X {{ $items->qty }}</div>
                                                <div class="h6">${{ $items->price * $items->qty }}</div>
                                            </div>
                                        @endforeach

                                        <div class="d-flex justify-content-between summery-end">
                                            <div class="h6"><strong>Subtotal</strong></div>
                                            {{-- <div class="h6"><strong>${{ Cart::subtotal() }}</strong></div> --}}
                                            @php
                                            $subtotal = str_replace(',', '', Cart::subtotal()); // Remove commas
                                            $subtotal = floatval($subtotal); // Convert to float
                                        @endphp
                                        
                                        <div class="h5"><strong><span id="subtotal">{{ number_format($subtotal, 2) }}</span></strong></div>                                        </div>
                                        {{-- <div class="d-flex justify-content-between summery-end">
                                            <div class="h6"><strong>Discount</strong></div>
                                            <div class="h6"><strong><span id="total_discount">0.00</span></strong></div>
                                        </div> --}}
                                        <div class="d-flex justify-content-between mt-2">
                                            <div class="h6"><strong>Shipping</strong></div>
                                            <div class="h6"><strong>$<span
                                                        id="shipping-charge">{{ number_format($totalShippingCharge, 2) }}</span></strong>
                                            </div>

                                        </div>
                                        <div class="d-flex justify-content-between mt-2 summery-end">
                                            <div class="h5"><strong>Total</strong></div>
                                            <div class="h5"><strong>$<span
                                                        id="total-amount">{{ Cart::subtotal() + $totalShippingCharge }}</span></strong>
                                            </div>
                                            {{-- <div class="h5"><strong><span id="total-amount">{{ number_format(Cart::subtotal() + $totalShippingCharge, 2) }}</span></strong></div> --}}

                                        </div>

                                        {{-- <div class="d-flex justify-content-between mt-2 summery-end">
                                            <div class="h5"><strong>Grand Total</strong></div>
                                            <div class="h5"><strong><span id="grand_total">{{ number_format(Cart::subtotal() + $totalShippingCharge, 2) }}</span></strong></div>
                                        </div> --}}
                                    </div>
                                </div>

                                <!-- Coupon Section -->
                                {{-- <div class="input-group apply-coupan mb-4">
                                    <input type="text" placeholder="Coupon Code" class="form-control"
                                        name="discount_code" id="discount_code">
                                    <button class="btn btn-dark" type="button" id="apply-discount">Apply
                                        Coupon</button>
                                </div> --}}


                                <!-- Payment Details -->
                                <div class="card shadow-lg border-0">
                                    <div class="card-body">
                                        <h4 class="mb-3">Payment Details</h4>
                                        <div>
                                            <input checked type="radio" name="payment_method" value="cod"
                                                id="payment_method_one">
                                            <label for="payment_method_one" class="form-check-label">COD</label>
                                        </div>
                                        <div>
                                            <input type="radio" name="payment_method" value="stripe"
                                                id="payment_method_two">
                                            <label for="payment_method_two" class="form-check-label">Stripe</label>
                                        </div>

                                        <!-- Card Payment Fields -->
                                        <div class="d-none mt-3" id="card-payment-form">
                                            <div class="mb-3">
                                                <label for="card_number" class="form-label">Card Number</label>
                                                <input type="text" name="card_number" id="card_number"
                                                    class="form-control" placeholder="Valid Card Number">
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="expiry_date" class="form-label">Expiry Date</label>
                                                    <input type="text" name="expiry_date" id="expiry_date"
                                                        class="form-control" placeholder="MM/YYYY">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="cvv" class="form-label">CVV Code</label>
                                                    <input type="text" name="cvv" id="cvv"
                                                        class="form-control" placeholder="123">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="pt-4">
                                            <button type="submit" class="btn btn-dark btn-block w-100">Pay
                                                Now</button>
                                        </div>
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

@section('customjs')
    <script>
        $('#payment_method_one').click(function() {
            if ($(this).is(':checked') == true) {
                $('#card-payment-form').addClass('d-none');
            }
        });

        $('#payment_method_two').click(function() {
            if ($(this).is(':checked') == true) {
                $('#card-payment-form').removeClass('d-none');
            }
        });

        //shipping charges
        $(document).ready(function() {
            $('#country').on('change', function() {
                let countryId = $(this).val();
                if (countryId) {
                    $.ajax({
                        url: "{{ route('getShippingCharge') }}", // Laravel route to fetch shipping charge
                        type: "GET",
                        data: {
                            country_id: countryId
                        },
                        success: function(response) {
                            if (response.success) {
                                let shippingCharge = response.shipping_charge;
                                let subtotal = parseFloat(
                                    "{{ Cart::subtotal() }}"); // Convert subtotal to float
                                let totalQty = 0;

                                @foreach (Cart::content() as $item)
                                    totalQty += {{ $item->qty }};
                                @endforeach

                                let totalShippingCharge = totalQty * shippingCharge;
                                let grandTotal = subtotal + totalShippingCharge;

                                // Update the shipping and total price in the UI
                                $('#shipping-charge').text(`${totalShippingCharge.toFixed(2)}`);
                                $('#total-amount').text(`${grandTotal.toFixed(2)}`);
                            } else {
                                // If no shipping charge found, reset values
                                $('#shipping-charge').text("0.00");
                                $('#total-amount').text("{{ Cart::subtotal() }}");
                            }
                        }
                    });
                }
            });
        });

        //apply coupon

//         $(document).ready(function() {
//     // Include CSRF token for all AJAX requests
//     $.ajaxSetup({
//         headers: {
//             "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
//         }
//     });

//     $("#apply-discount").click(function() {
//         var discountCode = $("#discount_code").val();
//         var countryId = $("#country").val();

//         $.ajax({
//             url: "{{ route('front.applyDiscount') }}",
//             type: "POST",
//             data: {
//                 code: discountCode,
//                 country_id: countryId
//             },
//             dataType: "json",
//             success: function(response) {
//                 if (response.status) {
//                     alert(response.message);
//                     $("#discount_amount").text("-$" + response.discount);
//                     updateTotal(); // Call function to update total price
//                 } else {
//                     alert(response.message);
//                 }
//             },
//             error: function(xhr) {
//                 alert("Something went wrong. Please try again.");
//                 console.error(xhr.responseText);
//             }
//         });
//     });

//     function updateTotal() {
//     $.ajax({
//         url: "{{ route('front.getCartTotal') }}",
//         type: "GET",
//         success: function(response) {
//             // Extract values from the response
//             const subtotal = parseFloat(response.subtotal); // 384.00
//             const shipping = parseFloat(response.shipping); // 250.00
//             const discount = parseFloat(response.discount); // 50.00

//             // Calculate Total and Grand Total
//             const total = subtotal + shipping; // 384 + 250 = 634
//             const grandTotal = total - discount; // 634 - 50 = 584

//             // Update the front-end display
//             $("#subtotal").text("$" + subtotal.toFixed(2)); // Subtotal
//             $("#total_discount").text("-$" + discount.toFixed(2)); // Discount
//             $("#shipping-charge").text("$" + shipping.toFixed(2)); // Shipping
//             $("#total-amount").text("$" + total.toFixed(2)); // Total (Subtotal + Shipping)
//             $("#grand_total").text("$" + grandTotal.toFixed(2)); // Grand Total (Total - Discount)
//         },
//         error: function(xhr) {
//             console.error("Error fetching cart totals:", xhr.responseText);
//         }
//     });
// }


// });

// $(document).on("change", "#shipping_method", function() {
//     var selectedShippingCharge = $(this).val();
    
//     $.ajax({
//         url: "{{ route('front.updateShipping') }}",
//         type: "POST",
//         data: { shipping_charge: selectedShippingCharge },
//         success: function(response) {
//             if (response.status) {
//                 $("#shipping-charge").text("$" + selectedShippingCharge);
//                 updateTotal(); // Refresh totals
//             }
//         }
//     });
// });


    </script>
@endsection

<style>
    .text-danger1 {
        color: #dc3545 !important;
        /* Default Bootstrap color */
        font-size: 0.875rem;
        /* Adjust font size for better visibility */
    }
</style>
