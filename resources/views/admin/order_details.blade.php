<!-- resources/views/admin/order_details.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        h2 {
            color: #4CAF50;
            margin-top: 20px;
        }

        p {
            font-size: 16px;
            color: #555;
        }

        .order-details {
            background-color: white;
            padding: 20px;
            margin: 20px auto;
            width: 80%;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .order-summary {
            background-color: #e7f3e7;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .order-summary strong {
            font-size: 18px;
            color: #333;
        }

        .order-items {
            margin-top: 20px;
            padding-left: 20px;
        }

        .order-items li {
            font-size: 16px;
            color: #555;
            margin-bottom: 10px;
        }

        .order-items li span {
            font-weight: bold;
            color: #333;
        }

        .btn-back {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
            font-size: 14px;
            margin-top: 30px;
        }

        .btn-back:hover {
            background-color: #45a049;
        }

        .shipping-status {
            margin-top: 30px;
            padding: 20px;
            background-color: #e7f3e7;
            border-radius: 5px;
        }

        .shipping-status select {
            padding: 10px;
            font-size: 14px;
            margin-right: 10px;
        }
    </style>
</head>
<body>

    <div class="order-details">
        <h1>Order Details - Order ID: {{ $order->id }}</h1>

        <div class="order-summary">
            <p><strong>Order Date:</strong> {{ $order->created_at->format('Y-m-d H:i:s') }}</p>
            <p><strong>Total Price:</strong> ${{ $order->total_price }}</p>
        </div>

        <h2>Order Items</h2>
        <ul class="order-items">
            @foreach($order->orderItems as $orderItem)
                <li>
                    <span>{{ $orderItem->product_name }}:</span>
                    {{ $orderItem->quantity }} x ${{ $orderItem->price }} = ${{ $orderItem->quantity * $orderItem->price }}
                </li>
            @endforeach
        </ul>

        

        <!-- Shipping Status Section -->
        <div class="shipping-status">
            <h2>Shipping Status</h2>
            <form action="{{ route('admin.updateShippingStatus', $order->id) }}" method="POST">
                @csrf
                @method('PUT')
                <select name="shipping_status" required>
                    <option value="Pending" {{ $order->shipping_status == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Shipped" {{ $order->shipping_status == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="Received" {{ $order->shipping_status == 'Received' ? 'selected' : '' }}>Received</option>
                </select>
                <button type="submit" class="btn-back">Update Status</button>
            </form>
        </div>
        <a href="{{ route('admin.orders') }}" class="btn-back">Back to Orders</a>
    </div>

</body>
</html>
