<!-- resources/views/order/confirmation.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>

    <!-- Inline CSS for styling -->
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .order-info {
            margin: 20px 0;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 4px;
        }
        .order-items {
            margin: 20px 0;
        }
        .order-items ul {
            list-style: none;
            padding: 0;
        }
        .order-items li {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin: 10px 5px;
        }
        .button:hover {
            background: #45a049;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Order Confirmation</h1>

        <p>Thank you for your order, <strong>{{ $order->username }}</strong>!</p>
        <div class="order-info">
            <p><strong>Order ID:</strong> {{ $order->id }}</p>
            <p><strong>Total Price:</strong> ৳{{ number_format($order->total_price, 2) }}</p>
            <p><strong>Shipping Address:</strong> {{ $order->address }}</p>
            <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
            <p><strong>Status:</strong> {{ $order->shipping_status }}</p>
        </div>

        <!-- Order Items -->
        <div class="order-items">
            <h3>Order Items:</h3>
            <ul>
                @foreach($order->orderItems as $item)
                    <li>{{ $item->product->product_name }} (x{{ $item->quantity }}) - ৳{{ number_format($item->price, 2) }}</li>
                @endforeach
            </ul>
        </div>

        <!-- Navigation Buttons -->
        <a href="{{ route('dashboard') }}" class="button">Go to Dashboard</a>
        <a href="{{ route('my.orders') }}" class="button">View All Orders</a>
        
    </div>

</body>
</html>
