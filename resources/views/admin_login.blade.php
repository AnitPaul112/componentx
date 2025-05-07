<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        /* Body styling */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #1e1e2f;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            position: relative;
        }

        /* Home button styling */
        .home-button {
            position: absolute;
            top: 20px;
            right: 20px;
            text-decoration: none;
            background-color: #ff6347;
            color: white;
            padding: 10px 20px;
            border-radius: 20px;
            font-size: 16px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .home-button:hover {
            background-color: #e5533f;
            transform: scale(1.1);
        }

        /* Login box styling */
        .login-box {
            background-color: #2c2c3d;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
            text-align: center;
            width: 100%;
            max-width: 400px;
            animation: fadeIn 0.8s ease;
        }

        /* Heading */
        .login-box h2 {
            margin-bottom: 30px;
            font-size: 28px;
            color: #fff;
            letter-spacing: 1px;
        }

        /* Form groups */
        .form-group {
            margin-bottom: 25px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: #bbb;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #444;
            border-radius: 8px;
            font-size: 16px;
            background-color: #1e1e2f;
            color: #ddd;
            box-sizing: border-box;
        }

        .form-group input:focus {
            border-color: #ff6347;
            outline: none;
        }

        /* Submit button */
        .btn-submit {
            width: 100%;
            padding: 12px;
            background-color: #ff6347;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn-submit:hover {
            background-color: #e5533f;
            transform: scale(1.05);
        }

        /* Keyframe animation for box entry */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive styling */
        @media (max-width: 480px) {
            .login-box {
                width: 90%;
                padding: 30px;
            }

            .home-button {
                font-size: 14px;
                padding: 8px 16px;
            }
        }
    </style>
</head>
<body>

    <!-- Home Button -->
    <a href="{{ route('home') }}" class="home-button">Home</a>

    <!-- Login Container -->
    <div class="login-box">
        <h2>Admin Login</h2>
        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit" class="btn-submit">Login</button>
        </form>
    </div>

</body>
</html>
