<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="theme-color" content="#563d7c">
    <meta name="author" content="Maxime LARROZE-FRANCEZAT">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Hackenathon System</title>
    <link rel="apple-touch-icon" href="{{ asset('/img/Hackenathon_System_logo.png') }}" sizes="180x180">
    <link rel="icon" href="{{ asset('/img/Hackenathon_System_logo.png') }}" sizes="32x32" type="image/png">
    <link rel="icon" href="{{ asset('/img/Hackenathon_System_logo.png') }}" sizes="16x16" type="image/png">
    <link rel="icon" href="{{ asset('/img/Hackenathon_System_logo.png') }}">

    <link type="text/css" rel="stylesheet" href="https://api.mqcdn.com/sdk/mapquest-js/v1.3.2/mapquest.css" />
    <script src="https://api.mqcdn.com/sdk/mapquest-js/v1.3.2/mapquest.js"></script>

    <link href="{{ asset('CDN/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('CDN/font-awesome.min.css') }}" rel="stylesheet">
    <script src="{{ asset('CDN/jquery.min.js') }}"></script>
    <script src="{{ asset('CDN/popper.min.js') }}"></script>
    <script src="{{ asset('CDN/bootstrap.min.js') }}"></script>
    <script src="{{ asset('CDN/a076d05399.js') }}"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.css" rel="stylesheet" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.js"></script>

</head>

<body class="antialiased">
    <nav class="navbar navbar-expand-lg bg-light navbar-light fixed-top">
        <a class="navbar-brand text-danger" href="{{ route('dashboard') }}">Hackenathon System</a>
        <button class="navbar-toggler text-dark" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
          <i class="fas fa-bars"></i>
        </button>
    </nav>

    <div class="container mt-5"> <br></div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="mt-3">
                    @yield('errors.404.show')
                    @yield('errors.403.show')
                </div>
            </div>
        </div>
    </div>

    <div class="text-center fixed-bottom">
        <p class="mt-2">Copyright 2021 &copy; Hackenathon System</p>
    </div>
</body>

</html>
