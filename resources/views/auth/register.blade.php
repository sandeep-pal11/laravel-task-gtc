<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        *{box-sizing:border-box;font-family:'Inter',sans-serif}

        body{
            min-height:100vh;
            background:linear-gradient(135deg,#667eea,#764ba2);
            display:flex;
            align-items:center;
            justify-content:center;
        }

        .auth-box{
            width:100%;
            max-width:460px;
            background:#fff;
            padding:36px;
            border-radius:18px;
            box-shadow:0 30px 60px rgba(0,0,0,.2);
            animation:fade .5s ease;
        }

        @keyframes fade{
            from{opacity:0;transform:translateY(20px)}
            to{opacity:1;transform:none}
        }

        h2{text-align:center;margin-bottom:6px}
        p{text-align:center;color:#666;font-size:14px;margin-bottom:26px}

        .group{margin-bottom:16px}
        label{font-size:13px;font-weight:500;margin-bottom:6px;display:block}

        input{
            width:100%;
            padding:13px;
            border-radius:9px;
            border:1px solid #ccc;
            font-size:14px;
            transition:.2s;
        }

        input:focus{
            outline:none;
            border-color:#667eea;
            box-shadow:0 0 0 3px rgba(102,126,234,.15);
        }

        .error{
            color:#e53e3e;
            font-size:12px;
            margin-top:4px;
            display:none;
        }

        .btn{
            width:100%;
            padding:14px;
            background:#667eea;
            color:#fff;
            border:none;
            border-radius:9px;
            font-size:15px;
            font-weight:500;
            cursor:pointer;
            margin-top:10px;
        }

        .btn:hover{background:#5a67d8}

        .divider{
            text-align:center;
            margin:26px 0;
            position:relative;
            font-size:12px;
            color:#999;
        }

        .divider:before,.divider:after{
            content:"";
            height:1px;
            width:40%;
            background:#ddd;
            position:absolute;
            top:50%;
        }

        .divider:before{left:0}
        .divider:after{right:0}

        .social{
            display:flex;
            justify-content:center;
            align-items:center;
            padding:13px;
            border-radius:9px;
            font-size:14px;
            font-weight:500;
            text-decoration:none;
            margin-bottom:12px;
            transition:.2s;
        }

        .google{border:1px solid #ddd;color:#444}
        .google:hover{background:#f5f5f5}

        .github{background:#24292e;color:#fff}
        .github:hover{background:#1b1f23}

        .footer{
            text-align:center;
            font-size:14px;
            margin-top:16px;
        }

        .footer a{color:#667eea;text-decoration:none;font-weight:500}
    </style>
</head>
<body>

<div class="auth-box">

    <h2>Create Account </h2>
    <p>Join us and start your journey</p>

    <form id="registerForm" method="POST" action="{{ route('register') }}">
        @csrf

        <div class="group">
            <label>Name</label>
            <input type="text" id="name" name="name">
            <div class="error" id="nameError"></div>
        </div>

        <div class="group">
            <label>Email</label>
            <input type="text" id="email" name="email">
            <div class="error" id="emailError"></div>
        </div>

        <div class="group">
            <label>Password</label>
            <input type="password" id="password" name="password">
            <div class="error" id="passwordError"></div>
        </div>

        <div class="group">
            <label>Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation">
            <div class="error" id="confirmError"></div>
        </div>

        <button class="btn">Register</button>
    </form>

    <div class="divider">OR</div>

    <a href="{{ url('/auth/google') }}" class="social google">
        Continue with Google
    </a>

    <a href="{{ url('/auth/github') }}" class="social github">
        Continue with GitHub
    </a>

    <div class="footer">
        Already have an account?
        <a href="{{ route('login') }}">Login</a>
    </div>

</div>

<script>
$('#registerForm').submit(function(e){
    let ok = true;
    $('.error').hide().text('');

    const emailReg = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if($('#name').val().trim() === ''){
        $('#nameError').text('Name is required').show(); ok=false;
    }

    if($('#email').val().trim() === ''){
        $('#emailError').text('Email is required').show(); ok=false;
    }else if(!emailReg.test($('#email').val())){
        $('#emailError').text('Invalid email').show(); ok=false;
    }

    if($('#password').val().length < 6){
        $('#passwordError').text('Minimum 6 characters').show(); ok=false;
    }

    if($('#password').val() !== $('#password_confirmation').val()){
        $('#confirmError').text('Passwords do not match').show(); ok=false;
    }

    if(!ok) e.preventDefault();
});
</script>

</body>
</html>
