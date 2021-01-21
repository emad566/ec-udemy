<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>Elite Admin Template - The Ultimate Multipurpose admin template</title>

    <!-- page css -->
    <link href="{{ asset('assets/dashboard/eliteadmin-theme/css/pages/login-register-lock.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('assets/dashboard/eliteadmin-theme/css/style.min.css') }}" rel="stylesheet">
    <!-- fontawesome-all -->
    <link href="{{ asset('assets/dashboard/eliteadmin-theme/assets/icons/font-awesome/css/fontawesome-all.css') }}" rel="stylesheet">

    <!-- Cairo Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js') }}"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js') }}"></script>
<![endif]-->

<style>
    body {
    --first-color:#36a265;
    --second-color:#161f6a;
    --third-color:#7d50de;
    font-family: 'Cairo', Georgia, 'Times New Roman', Times, serif;
    background-color:#f5f7fb
    }

    .h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
        font-family: 'Cairo', Georgia, 'Times New Roman', Times, serif;
    }

</style>
</head>

<body class="skin-default card-no-border">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Elite admin</p>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <section id="wrapper">
        <div class="login-register" style="background-image:url({{ asset('assets/dashboard/eliteadmin-theme/assets/images/background/login-register.jpg') }});">
            <div class="login-box card">
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" class="form-horizontal form-material" id="loginform">
                    @csrf
                        <h3 class="text-center m-b-20">{{ trans('main.Sign Up') }}</h3>
                        @include('dashboard.includes.alerts.success')
                        @include('dashboard.includes.alerts.errors')
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" aria-describedby="nameHelp"
                                placeholder="{{ trans('main.Name') }}" value="{{ old('name') }}" name="name" value="old('name')" required
                                autofocus autocomplete="name">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="email" aria-describedby="emailHelp"
                                placeholder="{{ trans('main.Email') }}" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="password" id="password" placeholder="{{ trans('main.Password') }}"
                                name="password" required autocomplete="new-password">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" type="password" id="cpassword"
                                placeholder="{{ trans('main.Confirm Password') }}" name="password_confirmation" required
                                autocomplete="new-password">
                            </div>
                        </div>
                        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                                    <label class="custom-control-label" for="customCheck1">{{ trans('main.I agree to all') }} <a href="javascript:void(0)">{{ trans('mian.Terms') }}</a></label>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="form-group text-center p-b-20">
                            <div class="col-xs-12">
                                <button class="btn btn-info btn-lg btn-block btn-rounded text-uppercase waves-effect waves-light" type="submit">{{ trans('main.Sign Up') }}</button>
                            </div>
                        </div>
                        <div class="form-group m-b-0">
                            <div class="col-sm-12 text-center">
                                {{ trans('main.Already have an account?') }} <a href="{{ route('login') }}" class="text-info m-l-5"><b>{{ trans('main.Sign In') }}</b></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{ asset('assets/dashboard/eliteadmin-theme/assets/node_modules/jquery/jquery-3.2.1.min.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('assets/dashboard/eliteadmin-theme/assets/node_modules/popper/popper.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/eliteadmin-theme/assets/node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!--Custom JavaScript -->
    <script type="text/javascript">
        $(function () {
            $(".preloader").fadeOut();
        });
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
        // ==============================================================
        // Login and Recover Password
        // ==============================================================
        $('#to-recover').on("click", function () {
            $("#loginform").slideUp();
            $("#recoverform").fadeIn();
        });
    </script>

</body>

</html>
