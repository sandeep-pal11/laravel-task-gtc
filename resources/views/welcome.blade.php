<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-box {
            width: 100%;
            max-width: 420px;
            background: #fff;
            padding: 34px;
            border-radius: 16px;
            box-shadow: 0 30px 60px rgba(0,0,0,0.2);
            animation: fadeIn 0.6s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 6px;
            font-weight: 600;
        }

        .login-box p {
            text-align: center;
            color: #666;
            margin-bottom: 26px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            margin-bottom: 6px;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 13px;
            border-radius: 9px;
            border: 1px solid #ccc;
            font-size: 14px;
            transition: 0.2s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102,126,234,0.15);
        }

        .remember {
            display: flex;
            align-items: center;
            font-size: 13px;
            gap: 6px;
        }

        .login-btn {
            width: 100%;
            padding: 14px;
            background: #667eea;
            color: #fff;
            border: none;
            border-radius: 9px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            margin-top: 20px;
            transition: 0.2s;
        }

        .login-btn:hover {
            background: #5a67d8;
            transform: translateY(-1px);
        }

        .forgot {
            text-align: right;
            margin-top: 6px;
        }

        .forgot a {
            font-size: 13px;
            color: #667eea;
            text-decoration: none;
        }

        .divider {
            text-align: center;
            margin: 26px 0;
            position: relative;
            font-size: 12px;
            color: #999;
        }

        .divider::before,
        .divider::after {
            content: "";
            height: 1px;
            width: 40%;
            background: #ddd;
            position: absolute;
            top: 50%;
        }

        .divider::before { left: 0; }
        .divider::after { right: 0; }

        .social-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 13px;
            border-radius: 9px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            margin-bottom: 12px;
            transition: 0.2s;
        }

        .google {
            background: #fff;
            border: 1px solid #ddd;
            color: #444;
        }

        .google:hover {
            background: #f5f5f5;
        }

        .github {
            background: #24292e;
            color: #fff;
        }

        .github:hover {
            background: #1b1f23;
        }

        .error {
            color: #e53e3e;
            font-size: 12px;
            margin-top: 4px;
            display: none;
        }

        .register-box {
            text-align: center;
            margin-top: 18px;
            font-size: 14px;
        }

        .register-box a {
            color: #667eea;
            font-weight: 500;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="login-box">

    <h2>Welcome Back </h2>
    <p>Login to continue to your dashboard</p>

    <form id="loginForm" method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" id="email">
            <div class="error" id="emailError"></div>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" id="password">
            <div class="error" id="passwordError"></div>
        </div>

        <div class="remember">
            <input type="checkbox" name="remember">
            <span>Remember me</span>
        </div>

        <div class="forgot">
            <a href="{{ route('password.request') }}">Forgot password?</a>
        </div>

        <button type="submit" class="login-btn">Login</button>
    </form>

    <div class="divider">OR</div>

    <a href="{{ url('/auth/google') }}" class="social-btn google">Continue with Google</a>
    <a href="{{ url('/auth/github') }}" class="social-btn github">Continue with GitHub</a>

    <div class="register-box">
        New here? <a href="{{ route('register') }}">Create an account</a>
    </div>

</div>

<script>
    $('#loginForm').on('submit', function (e) {
        let valid = true;

        $('.error').hide().text('');

        const email = $('#email').val().trim();
        const password = $('#password').val().trim();
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (email === '') {
            $('#emailError').text('Email is required').show();
            valid = false;
        } else if (!emailPattern.test(email)) {
            $('#emailError').text('Enter a valid email address').show();
            valid = false;
        }

        if (password === '') {
            $('#passwordError').text('Password is required').show();
            valid = false;
        } else if (password.length < 6) {
            $('#passwordError').text('Password must be at least 6 characters').show();
            valid = false;
        }

        if (!valid) {
            e.preventDefault();
        }
    });
</script>

</body>
</html>
