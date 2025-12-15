<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | Laravel Auth</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

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
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .login-box p {
            text-align: center;
            color: #666;
            margin-bottom: 25px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            margin-bottom: 6px;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 11px 12px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
        }

        .remember {
            display: flex;
            align-items: center;
            font-size: 14px;
        }

        .remember input {
            margin-right: 6px;
        }

        .login-btn {
            width: 100%;
            padding: 12px;
            background: #667eea;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            margin-top: 15px;
        }

        .login-btn:hover {
            background: #5a67d8;
        }

        .forgot {
            text-align: right;
            margin-top: 8px;
        }

        .forgot a {
            font-size: 13px;
            color: #667eea;
            text-decoration: none;
        }

        .divider {
            text-align: center;
            margin: 25px 0;
            position: relative;
            font-size: 13px;
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
            padding: 11px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            margin-bottom: 10px;
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
            font-size: 13px;
            margin-top: 5px;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Welcome Back</h2>
    <p>Login to your account</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
            @error('email') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
            @error('password') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="remember">
            <input type="checkbox" name="remember">
            <span>Remember me</span>
        </div>

        <div class="forgot">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">Forgot password?</a>
            @endif
        </div>

        <button class="login-btn">Login</button>
    </form>

    <div class="divider">OR</div>

    <a href="{{ url('/auth/google') }}" class="social-btn google">
        Continue with Google
    </a>

    <a href="{{ url('/auth/github') }}" class="social-btn github">
        Continue with GitHub
    </a>
</div>

</body>
</html>
