<!-- resources/views/admin/view-users.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List</title>
    <!-- Add your custom CSS for styling here -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        /* Sidebar Styles */
        .sidebar {
            height: 100vh;
            width: 250px;
            background-color: #343a40;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 30px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar h4 {
            text-align: center;
            margin-bottom: 30px;
            color: white;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            display: block;
            font-size: 16px;
            transition: background-color 0.3s ease;
            margin: 5px 0;
        }

        .sidebar a:hover {
            background-color: #007bff;
            border-radius: 5px;
        }

        .sidebar .active {
            background-color: #007bff;
            border-radius: 5px;
        }

        /* Main content area */
        .content {
            margin-left: 260px;
            padding: 20px;
        }

        /* Adjusting table layout */
        #users-table {
            width: 100%;
        }

        /* Back to dashboard button styling */
        .btn-back {
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <!-- Side Nav Bar -->
    <div class="sidebar">
        <h4>Admin Dashboard</h4>
        <ul class="list-unstyled">
            <li><a href="{{ route('admin.dashboard') }}" class="active">Dashboard</a></li>
            <li><a href="{{ route('admin.viewUsers') }}">Manage Users</a></li>
            <li><a href="{{ route('admin.orders') }}">Orders</a></li>
            <li><a href="#">Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="content">

        <h1 class="mt-5">Users List</h1>
        <table id="users-table" class="table table-striped mt-4">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at ? $user->created_at->format('Y-m-d') : 'No Date' }}</td>
                        <td>
                            <a href="{{ route('admin.viewUser', $user->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('admin.editUser', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.deleteUser', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Include jQuery and DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#users-table').DataTable(); // Initialize DataTables
        });
    </script>
</body>
</html>
