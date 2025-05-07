<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            color: #333;
        }

        /* Sidebar Styles */
        .sidebar {
            height: 100vh;
            width: 250px;
            background-color: #343a40;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar h4 {
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 12px;
            display: block;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #007bff;
            border-radius: 5px;
        }

        .sidebar .active {
            background-color: #007bff;
            border-radius: 5px;
        }

        /* Sidebar Logout Button Styles */
        .sidebar .logout-btn {
            background: none;
            border: none;
            color: white;
            padding: 12px;
            font-size: 16px;
            text-align: left;
            width: 100%;
            cursor: pointer;
            text-decoration: none;
            display: block;
            transition: background-color 0.3s ease;
        }
        
        .sidebar .logout-btn:hover {
            background-color: #007bff;
            border-radius: 5px;
        }

        /* Main Content Styles */
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        .main-content h1 {
            font-size: 36px;
            margin-bottom: 20px;
            color: #333;
        }

        .main-content p {
            font-size: 18px;
            color: #555;
            margin-bottom: 30px;
        }

        .main-content .mt-4 {
            margin-top: 30px;
        }

        .main-content h3 {
            font-size: 28px;
            margin-bottom: 15px;
            color: #444;
        }

        .main-content ul {
            list-style-type: none;
            padding-left: 0;
        }

        .main-content ul li {
            margin: 10px 0;
        }

        .main-content ul li a {
            font-size: 18px;
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .main-content ul li a:hover {
            color: #0056b3;
        }

        /* Footer Styles */
        .footer {
            position: absolute;
            bottom: 0;
            left: 250px;
            right: 0;
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 10px;
            font-size: 14px;
        }

    </style>
</head>
<body>
    <div class="d-flex">
        <div class="sidebar">
            <h4>Admin Dashboard</h4>
            <ul class="list-unstyled">
                <li><a href="#" class="active">Dashboard</a></li>
                <li><a href="{{ route('admin.viewUsers') }}">Manage Users</a></li>
                <li><a href="{{ route('admin.orders') }}">Orders</a></li>
                <li><a href="{{ route('admin.discounts') }}">Discount</a></li>
                <li>
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="logout-btn">Logout</button>
                    </form>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="container">
                <h1>Welcome to the Admin Dashboard</h1>
                <p>You are logged in as an admin. Manage the website from here.</p>
                <p>Admin ID: {{ $admin->id }}.</p>
                <p>Email: {{ $admin->email }}</p>

                <div class="mt-4">
                    <h3>Admin Options:</h3>
                    <ul>
                        <li><a href="{{ route('admin.viewUsers') }}">View user</a></li>
                        <li><a href="{{ route('admin.orders') }}">View Order</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2024 Admin Dashboard. All rights reserved.</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
