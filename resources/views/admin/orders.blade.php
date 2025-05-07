<!-- admin/orders.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Orders</title>
    <style>
        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-family: Arial, sans-serif;
        }

        /* Table Header */
        th {
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            text-align: left;
        }

        /* Table Rows */
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        /* Table Row Hover Effect */
        tr:hover {
            background-color: #f2f2f2;
        }

        /* Styling for Order Items */
        td p {
            margin: 5px 0;
        }

        /* Total Price Styling */
        td p.price {
            font-weight: bold;
            color: #555;
        }

        /* Additional styling for the page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Styling for the buttons */
        .btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            margin: 10px 0;
            display: inline-block;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <!-- Dashboard Button -->
    <a href="{{ route('admin.dashboard') }}" class="btn">Dashboard</a>

    <h1>Admin Orders</h1>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Order Date</th>
                <th>Total Price</th>
                <th>Shipping Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->created_at->format('Y-m-d H:i:s') }}</td>
                <td>${{ $order->total_price }}</td>
                <td>{{ $order->shipping_status }}</td>
                <td>
                    <a href="{{ route('admin.order.details', $order->id) }}" class="btn-details">Details</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
