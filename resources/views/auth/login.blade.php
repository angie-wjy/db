<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Poppins:wght@400;500;600;700&display=swap');

        :root {
            --primary-color: #fbf404;
            --primary-color-dark: #f8d70a;
            --primary-color-light: #eee9e7;
            --text-dark: #262220;
            --text-light: #7c7c79;
            --extra-light: #f8fafc;
            --white: #ffffff;
            --header-font: "Playfair Display", serif;
        }

        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--primary-color-light);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .signin-container {
            background-color: var(--white);
            padding: 2rem;
            max-width: 400px;
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .signin-header {
            font-size: 2rem;
            font-family: var(--header-font);
            color: var(--text-dark);
            margin-bottom: 1rem;
            font-weight: 800;
        }

        .signin-subheader {
            color: var(--text-light);
            margin-bottom: 2rem;
            font-size: 1rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            text-align: left;
        }

        .form-label {
            font-weight: 500;
            color: var(--text-dark);
            display: block;
            margin-bottom: 0.5rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem;
            font-size: 1rem;
            color: var(--text-dark);
            background-color: var(--extra-light);
            border: 1px solid var(--primary-color-light);
            border-radius: 5px;
            outline: none;
            transition: 0.3s;
        }

        .form-input:focus {
            border-color: var(--primary-color);
        }

        .btn-signin {
            width: 100%;
            padding: 0.75rem;
            font-size: 1rem;
            color: var(--white);
            background-color: var(--primary-color);
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        .btn-signin:hover {
            background-color: var(--primary-color-dark);
        }

        .signin-footer {
            margin-top: 1.5rem;
            font-size: 0.9rem;
            color: var(--text-light);
        }

        .signin-footer a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .signin-footer a:hover {
            color: var(--primary-color-dark);
        }
    </style>

    <div class="signin-container">
        <h1 class="signin-header">Login</h1>
        <p class="signin-subheader">Welcome back! Please Login to your account.</p>
        <form method="POST" action="{{ route('signin') }}">
            @csrf
            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input type="email" id="email" name="email" class="form-input" placeholder="Enter your email">
                @error('email')
                <p style="color: red"> {{$message}}</p>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input type="password" id="password" name="password" class="form-input" placeholder="Enter your password">
                @error('password')
                <p style="color: red"> {{$message}}</p>
                @enderror
            </div>
            @if (session()->has('error_sign'))
            <p style="color: red"> Failed to Login , check your credentials </p>
            @endif
            <button type="submit" class="btn-signin">Login</button>
        </form>
        <div class="signin-footer">
            <p>Don’t have an account? <a href="/register">Register</a></p>
        </div>
        @include('component.notification')
    </div>
</head>
</html>
