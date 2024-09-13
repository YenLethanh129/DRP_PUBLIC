<?

use App\Controllers\UserController;

    if(UserController::isLoggedIn()){
        header("Location: /index");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/vendor/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/Public/css/login-style.css">
    <style>
        .error-message {
        color: #ff4d4d;
        font-size: 14px;
    }
    </style>
</head>

<body>
    <div class="container" id="container">   
        <div class="form-container sign-up">
            <form id="sign-up-form" name="frmPOST" method="POST" action="/registery">
                <h1>Create account</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa fa-google"></i></a>
                    <a href="#" class="icon"><i class="fa fa-facebook"></i></a>
                    <a href="#" class="icon"><i class="fa fa-github"></i></a>
                </div>
                <p style="font-weight: bolder; margin: 10px 0;">OR</p>
                <span>Register with your email</span>
                <input type="text" name="username" id="username" placeholder="Enter your username.">
                <input type="email" name="email" id="email" placeholder="Enter your email.">
                <input type="password" name="password" id="password" placeholder="Enter your password.">
                <input type="password" name="repassword" id="repassword" placeholder="Re-enter your password.">
                <button>Sign up</button>
                
            </form>
            <form action="" class="show" id="forgot-form">
                <h1>Forgot Password?</h1>
                <p>Enter your email to reset your password.</p>
                <input type="email" placeholder="Your email">
                <button>Reset Password</button>
            </form>
        </div>

        <div class="form-container sign-in">
            <form id="login-form" name="frmPOST" method="POST" action="/login">
                <h1>Sign In</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa fa-google"></i></a>
                    <a href="#" class="icon"><i class="fa fa-facebook"></i></a>
                    <a href="#" class="icon"><i class="fa fa-github"></i></a>
                </div>
                <p style="font-weight: bolder;margin: 10px 0;">OR</p>
                <span>Sign in with your username</span>
                <input type="text" name="username" id="username" placeholder="Enter your username.">
                <input type="password" name="password" id="password" placeholder="Enter your password.">
                <p style="cursor: pointer;" id="forgot">Forgot your password?</p>
                <button type="submit" name="login">Sign in</button>

            </form>
        </div>

        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-right"> 
                    <h1>Welcome Back!</h1>
                    <a href="/homepage">
                        <img src="/Public/images/logo.png" alt="" style="height:100px" >
                    </a>
                    <h3>PaPals - Enjoy your meals</h3>
                <p>Sign in to your account to continue.</p>
                <button class="hidden" id="register">Sign up</button>
            </div>
            
            <div class="toggle-panel toggle-left"> 
                <h1>Welcome to Palpals!</h1>
                <a href="/homepage">
                    <img src="/Public/images/logo.png" alt="" style="height:100px" >
                </a>
                <p>Register to be a part of us for much more site features.</p>
                <button class="hidden" id="login">Sign in</button>
                </div>
            </div>
        </div>
    </div>

    <script src="/Public/js/login-page.js"></script>
    <!-- Include jQuery library -->
    <script src="/Public/js/libs/jquery/jquery-3.5.1.min.js"></script>
    <!-- Include jQuery Validate plugin -->
    <script src="/Public/js/libs/jquery/jquery-1.19.2.min.js"></script>
    <script src="/Public/js/validate-signup.js"></script>
    <script src="/Public/js/validate-login.js"></script>
    
    
</body>
</html> 
