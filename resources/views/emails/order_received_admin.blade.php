<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New Order Received</title>
</head>

<body>
    <h1>New Order Received</h1>
    <p>You have received a new order with the following details:</p>
    <ul>
        <li>Order ID: {{ $order->id }}</li>
        <li>Customer Name: {{ $order->first_name }} {{ $order->last_name }}</li>
        <li>Email: {{ $order->email }}</li>
        <li>Total Amount: ${{ number_format($order->grand_total, 2) }}</li> 
    </ul>
    <p>Please check the admin panel for more details.</p>
</body>

</html>
