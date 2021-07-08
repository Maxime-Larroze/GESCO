<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="theme-color" content="#563d7c">
    <meta name="author" content="Maxime LARROZE-FRANCEZAT">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GesCo Online</title>
    <link rel="apple-touch-icon" href="{{ asset('/img/Hackenathon_System_logo.png') }}" sizes="180x180">
    <link rel="icon" href="{{ asset('/img/Hackenathon_System_logo.png') }}" sizes="32x32" type="image/png">
    <link rel="icon" href="{{ asset('/img/Hackenathon_System_logo.png') }}" sizes="16x16" type="image/png">
    <link rel="icon" href="{{ asset('/img/Hackenathon_System_logo.png') }}">

    <link href="{{ asset('CDN/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('CDN/font-awesome.min.css') }}" rel="stylesheet">
    <script src="{{ asset('CDN/jquery.min.js') }}"></script>
    <script src="{{ asset('CDN/popper.min.js') }}"></script>
    <script src="{{ asset('CDN/bootstrap.min.js') }}"></script>
    <script src="{{ asset('CDN/a076d05399.js') }}"></script>
</head>

<body class="antialiased">
    <div class="mt-5 container">
        <div class="mt-5 row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6 text-center mt-5 border card rounded-lg shadow-lg" id="content-card">
                <img src="{{ asset('/img/Hackenathon_System_logo.png') }}" alt="Logo"
                    class="img-fluid mx-auto d-block mt-5" width="30%">
                <h5 class="font-italic mt-3">Hackenathon System</h5>
                <h6 class="font-italic mb-3">Gestion Commerciale Online</h6>
                <div class="row">
                    <div class="col-lg-12">
                        <hr class="solid">
                    </div>
                    <div class="col-lg-12">
                        @error('validate')
                        <div class="alert alert-success alert-dismissible text-center">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <p>{{$message}}</p>
                          </div>
                        @enderror
                        @error('error')
                        <div class="alert alert-danger alert-dismissible text-center">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <p>{{$message}}</p>
                          </div>
                        @enderror
                    </div>
                    <div class="col-lg-4 text-center text-danger mb-3"><a class="text-danger"
                            href="{{ route('register.google') }}"><button type="submit" id="btn_submit"
                                class="btn btn-danger">Se connecter avec Google <i class="fab fa-google"></i></button></a>
                    </div>
                    <div class="col-lg-4 text-center text-white mb-3"><a class="text-white"
                            href="{{ route('register.github') }}"><button type="submit" id="btn_submit"
                                class="btn btn-dark">Se connecter avec Github <i class="fab fa-github"></i></button></a>
                    </div>
                    <div class="col-lg-4 text-center text-danger mb-3"><a class="text-danger"
                            href="{{ route('register.facebook') }}"><button type="submit" id="btn_submit"
                                class="btn btn-primary">Se connecter avec Facebook <i class="fab fa-facebook"></i></button></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3"></div>
            <div class="col-lg-12 text-center mt-5 text-gray-600">Copyright 2021 &copy; Hackenathon System</div>
        </div>
    </div>
</body>

</html>
