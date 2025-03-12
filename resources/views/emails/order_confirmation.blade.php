<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #007bff;
            color: #ffffff;
            text-align: center;
            padding: 15px;
            font-size: 24px;
            font-weight: bold;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        .order-details {
            margin: 20px 0;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .order-details p {
            margin: 5px 0;
            font-size: 16px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .items-table th, .items-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .items-table th {
            background-color: #007bff;
            color: #ffffff;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            font-size: 14px;
            color: #666;
            margin-top: 20px;
            padding: 10px;
            border-top: 1px solid #ddd;
        }
        .btn {
            display: inline-block;
            background-color: #007bff;
            color: #ffffff;
            padding: 10px 20px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
            margin-top: 10px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            Order Confirmation
        </div>

        <p>Hello {{ $order->first_name }},</p>
        <p>Thank you for your order! Below are your order details:</p>

        <h3>Order Items</h3>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>${{ number_format($item->price * $item->qty, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="order-details">
            <p><strong>Order ID:</strong> #{{ $order->id }}</p>
            <p><strong>Subtotal:</strong> ${{ number_format($order->subtotal, 2) }}</p>
            <p><strong>Shipping:</strong> ${{ number_format($order->shipping, 2) }}</p>
            <p><strong>Grand Total:</strong> ${{ number_format($order->grand_total, 2) }}</p>
        </div>

        <h3>Shipping Address</h3>
        <p> <strong>Name:</strong>  {{ $order->first_name }} {{ $order->last_name }}</p>
        <p> <strong>Address:</strong>  {{ $order->address }}</p>
        <p> <strong>City:</strong>  {{ $order->city }}, <strong>State:</strong>  {{ $order->state }} <strong>Zip Code:</strong> {{ $order->zip }}</p>
        <p> <strong>Country:</strong>  {{ $order->country->name }}</p>

        <p>We appreciate your business and hope to serve you again soon!</p>

        <div style="text-align: center;">
            <a href="{{ url('/') }}" class="btn">Visit Our Store</a>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Foodmart. All rights reserved.
        </div>
    </div>

</body>
</html>
