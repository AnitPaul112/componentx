<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discounts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            font-family: Arial, sans-serif;
        }

        /* Side Navigation Bar */
        .sidebar {
            height: 100vh;
            width: 250px;
            background-color: #343a40;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 20px;
        }

        .sidebar a {
            display: block;
            padding: 15px;
            color: white;
            text-decoration: none;
            font-size: 18px;
        }

        .sidebar a:hover {
            background-color: #575d63;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            padding: 20px;
            flex: 1;
        }

        .table thead {
            background-color: #f8f9fa;
        }

        .table th, .table td {
            text-align: center;
        }

        .container h1 {
            margin-bottom: 20px;
        }

        .form-container {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <!-- Side Navigation Bar -->
    <div class="sidebar">
        <a href="#">Dashboard</a>
        <a href="#">Products</a>
        <a href="#">Orders</a>
        <a href="#">Discounts</a>
        <a href="#">Users</a>
        <a href="#">Settings</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container mt-4">
            <h1>Discounts</h1>

            <!-- Form to Add Discount -->
            <div class="form-container">
                <h3>Add New Discount</h3>
                <form method="POST" action="{{ route('discount.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="code" class="form-label">Code</label>
                        <input type="text" class="form-control" id="code" name="code" required>
                    </div>
                    <div class="mb-3">
                        <label for="discount_percentage" class="form-label">Discount Percentage</label>
                        <input type="number" class="form-control" id="discount_percentage" name="discount_percentage" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="valid_from" class="form-label">Valid From</label>
                        <input type="datetime-local" class="form-control" id="valid_from" name="valid_from" required>
                    </div>
                    <div class="mb-3">
                        <label for="valid_until" class="form-label">Valid Until</label>
                        <input type="datetime-local" class="form-control" id="valid_until" name="valid_until" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Discount</button>
                </form>
            </div>

            <!-- Table Displaying Discounts -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Code</th>
                        <th>Discount Percentage</th>
                        <th>Valid From</th>
                        <th>Valid Until</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($coupons as $discount)
                        <tr>
                            <td>{{ $discount->id }}</td>
                            <td>{{ $discount->code }}</td>
                            <td>{{ $discount->discount_percentage }}%</td>
                            <td>{{ $discount->valid_from }}</td>
                            <td>{{ $discount->valid_until }}</td>
                            <td>
                                <form action="{{ route('discount.destroy', $discount->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this discount?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
