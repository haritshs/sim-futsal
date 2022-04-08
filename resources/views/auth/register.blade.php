
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Register</title>

    <link href="{{ asset('template/css/font-face.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('template/vendor/font-awesome-4.7/css/font-awesome.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('template/vendor/font-awesome-5/css/fontawesome-all.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('template/vendor/mdi-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="{{ asset('template/vendor/bootstrap-4.1/bootstrap.min.css') }}" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="{{ asset('template/vendor/animsition/animsition.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('template/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('template/vendor/wow/animate.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('template/vendor/css-hamburgers/hamburgers.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('template/vendor/slick/slick.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('template/vendor/select2/select2.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('template/vendor/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="{{ asset('template/css/theme.css') }}" rel="stylesheet" media="all">

</head>

<body class="animsition">
    <div class="page-wrapper">
        <div class="page-content--bge5">
            <div class="container">
                <div class="login-wrap">
                    <div class="login-content">
                        <div class="login-logo">
                            <a href="#">
                                <h2>Register User</h2>
                            </a>
                        </div>
                        <div class="login-form">
                            
                            @if (session('status'))
                            <div>
                            {{ session('status') }}
                            </div>
                            @endif
                            <form action="{{ route('register') }}" method="post">
                            {!! csrf_field() !!}
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input class="au-input au-input--full" type="text" name="name" placeholder="Nama">
                                    @if ($errors->has('name'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input class="au-input au-input--full" type="email" name="email" placeholder="Email">
                                    @if ($errors->has('email'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>No Telepon</label>
                                    <input class="au-input au-input--full" type="text" name="no_telpon" placeholder="No Telepon">
                                    @if ($errors->has('no_telpon'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('no_telpon') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Alamat </label>
                                    <input class="au-input au-input--full" type="text" name="alamat" placeholder="Alamat">
                                    @if ($errors->has('alamat'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('alamat') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="au-input au-input--full" type="password" name="password" placeholder="Password">
                                    @if ($errors->has('password'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Konfirmasi Password</label>
                                    <input class="au-input au-input--full" type="password" name="password_confirmation" placeholder="Konfirmasi Password">
                                </div>
                                <button class="au-btn au-btn--block au-btn--orange m-b-20" type="submit">register</button>
                            </form>
                            <div class="register-link">
                                <p>
                                    Sudah punya akun?
                                    <a href="{{ route('login') }}">Sign In</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('template/vendor/jquery-3.2.1.min.js') }}"></script>
    <!-- Bootstrap JS-->
    <script src="{{ asset('template/vendor/bootstrap-4.1/popper.min.js') }}"></script>
    <script src="{{ asset('template/vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>
    <!-- Vendor JS       -->
    <script src="{{ asset('template/vendor/slick/slick.min.js') }}"></script>
    <script src="{{ asset('template/vendor/wow/wow.min.js') }}"></script>
    <script src="{{ asset('template/vendor/animsition/animsition.min.js') }}"></script>
    <script src="{{ asset('template/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
    <script src="{{ asset('template/vendor/counter-up/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('template/vendor/counter-up/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('template/vendor/circle-progress/circle-progress.min.js') }}"></script>
    <script src="{{ asset('template/vendor/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('template/vendor/chartjs/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('template/vendor/select2/select2.min.js') }}">
    </script>
    <!-- Main JS-->
    <script src="{{ asset('template/js/main.js') }}"></script>

</body>

</html>
<!-- end document-->