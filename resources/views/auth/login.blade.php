<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vastech Cloud </title>
    <link rel="icon" type="image/png" href="/assets/img/logovastech.webp">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/gentelella/vendors/font-awesome/css/font-awesome.min.css') }}">
    <!-- NProgress -->
    <link rel="stylesheet" href="{{ asset('assets/gentelella/vendors/nprogress/nprogress.css') }}">

    <link href="../vendors/animate.css/animate.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link rel="stylesheet" href="{{ asset('assets/gentelella/build/css/custom.min.css') }}">
    <style>
        @media print {
            #ghostery-purple-box {
                display: none !important
            }
        }
    </style>
</head>

<body class="login">
    <div>
        <a class="hiddenanchor" id="signup"></a>
        <a class="hiddenanchor" id="signin"></a>
        <div class="login_wrapper">
            <div class="animate form login_form">
                <section class="login_content">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <h1>Sign In</h1>
                        <div>
                            <input type="email" placeholder="Email" id='email'
                                class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div>
                            <button type="submit" class="btn btn-default submit">
                                    {{ __('Login') }}
                            </button>
                            <!--
                            <a class="reset_pass" href="#">Lost your password?</a>
                            -->
                        </div>
                        <div class="clearfix"></div>
                        <div class="separator">
                            <!--
                            <p class="change_link">New to site?
                                <a href="#signup" class="to_register"> Create Account </a>
                            </p>
                            -->
                            <div class="clearfix"></div>
                            <br>
                            <div>
                                <h1>Vastech Cloud</h1>
                                <p>©2019 All Rights Reserved.</p>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
            <div id="register" class="animate form registration_form">
                <section class="login_content">
                    <form>
                        <h1>Create Account</h1>
                        <div>
                            <input type="text" class="form-control" placeholder="Username" required="">
                        </div>
                        <div>
                            <input type="email" class="form-control" placeholder="Email" required="">
                        </div>
                        <div>
                            <input type="password" class="form-control" placeholder="Password" required="">
                        </div>
                        <div>
                            <a class="btn btn-default submit" href="index.html">Submit</a>
                        </div>
                        <div class="clearfix"></div>
                        <div class="separator">
                            <p class="change_link">Already a member ?
                                <a href="#signin" class="to_register"> Log in </a>
                            </p>
                            <div class="clearfix"></div>
                            <br>
                            <div>
                                <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
                                <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and
                                    Terms</p>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>


</body>

</html>