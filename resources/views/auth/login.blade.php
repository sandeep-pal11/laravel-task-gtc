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
            cursor: pointer;
            margin-top: 20px;
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
            padding: 13px;
            border-radius: 9px;
            font-size: 14px;
            text-decoration: none;
            display: block;
            text-align: center;
            margin-bottom: 12px;
        }

        .google {
            background: #fff;
            border: 1px solid #ddd;
            color: #444;
        }

        .github {
            background: #24292e;
            color: #fff;
        }

        .error {
            color: #e53e3e;
            font-size: 13px;
            margin-bottom: 12px;
            display: none;
        }

        .register-box {
            text-align: center;
            margin-top: 18px;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="login-box">

    <h2>Welcome Back</h2>
    <p>Login to continue to your dashboard</p>

    {{-- ✅ SERVER SIDE ERROR (IMPORTANT FIX) --}}
    @if ($errors->any())
        <div class="error" style="display:block;">
            {{ $errors->first() }}
        </div>
    @endif

    <form id="loginForm" method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}">
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

        <button type="submit" class="login-btn">Login</button>
    </form>

    <div class="divider">OR</div>

    <a href="{{ url('/auth/google') }}" class="social-btn google">
        Continue with Google
    </a>

    <a href="{{ url('/auth/github') }}" class="social-btn github">
        Continue with GitHub
    </a>

    <div class="register-box">
        New here? <a href="{{ route('register') }}">Create an account</a>
    </div>

</div>

<script>
$('#loginForm').on('submit', function (e) {

    let valid = true;
    $('.error').hide().text('');

    let email = $('#email').val().trim();
    let password = $('#password').val().trim();
    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (email === '') {
        $('#emailError').text('Email is required').show();
        valid = false;
    } else if (!emailPattern.test(email)) {
        $('#emailError').text('Enter a valid email').show();
        valid = false;
    }

    if (password === '') {
        $('#passwordError').text('Password is required').show();
        valid = false;
    }

    if (!valid) e.preventDefault();
});
</script>

</body>
</html>
