<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up Form</title>

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
            /* height: 100vh; */
            min-height: calc(100vh - 100px);
            padding-top: 50px;
            padding-bottom: 50px;
        }

        .signup-container {
            background-color: var(--white);
            padding: 2rem;
            max-width: 500px;
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .signup-header {
            font-size: 2rem;
            font-family: var(--header-font);
            color: var(--text-dark);
            margin-bottom: 1rem;
            font-weight: 800;
        }

        .signup-subheader {
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

        .btn-signup {
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

        .btn-signup:hover {
            background-color: var(--primary-color-dark);
        }

        .signup-footer {
            margin-top: 1.5rem;
            font-size: 0.9rem;
            color: var(--text-light);
        }

        .signup-footer a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .signup-footer a:hover {
            color: var(--primary-color-dark);
        }
    </style>
</head>

<body>
    <div class="signup-container">
        <h1 class="signup-header">Sign Up</h1>
        <p class="signup-subheader">Create your account to join us!</p>
        {{-- <form method="POST" action="/signup"> --}}
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label class="form-label" for="username">Username</label>
                <input type="text" id="username" name="username" class="form-input"
                    placeholder="Enter your username">
                @error('username')
                    <p style="color: red">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input type="email" id="email" name="email" class="form-input" placeholder="Enter your email">
                @error('email')
                    <p style="color: red">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="name">Name</label>
                <input type="text" id="name" name="name" class="form-input"
                    placeholder="Enter your full name">
                @error('name')
                    <p style="color: red">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" class="form-input"
                    placeholder="Enter your phone number">
                @error('phone')
                    <p style="color: red">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input type="password" id="password" name="password" class="form-input"
                    placeholder="Enter your password">
                @error('password')
                    <p style="color: red">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-input"
                    placeholder="Re-enter your password">
                @error('password_confirmation')
                    <p style="color: red">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="btn-signup">Sign Up</button>
        </form>
        <div class="signup-footer">
            <p>Already have an account? <a href="/signin">Sign In</a></p>
        </div>
    </div>
</body>

</html>
