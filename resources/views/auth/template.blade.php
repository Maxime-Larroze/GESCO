<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="theme-color" content="#563d7c">
    <meta name="author" content="Maxime LARROZE-FRANCEZAT">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Hackenathon System</title>
    <link rel="apple-touch-icon" href="{{ asset('/Logos/logo_transparent.png') }}" sizes="180x180">
    <link rel="icon" href="{{ asset('/Logos/logo_transparent.png') }}" sizes="32x32" type="image/png">
    <link rel="icon" href="{{ asset('/Logos/logo_transparent.png') }}" sizes="16x16" type="image/png">
    <link rel="icon" href="{{ asset('/Logos/logo_transparent.png') }}">

    <link type="text/css" rel="stylesheet" href="https://api.mqcdn.com/sdk/mapquest-js/v1.3.2/mapquest.css" />
    <script src="https://api.mqcdn.com/sdk/mapquest-js/v1.3.2/mapquest.js"></script>

    <link href="{{ asset('CDN/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('CDN/font-awesome.min.css') }}" rel="stylesheet">
    <script src="{{ asset('CDN/jquery.min.js') }}"></script>
    <script src="{{ asset('CDN/popper.min.js') }}"></script>
    <script src="{{ asset('CDN/bootstrap.min.js') }}"></script>
    <script src="{{ asset('CDN/a076d05399.js') }}"></script>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.css" rel="stylesheet" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.js"></script>

</head>

<body class="antialiased">
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark fixed-top">
        <a class="navbar-brand text-danger" href="{{ route('dashboard') }}">Hackenathon System</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('dashboard') }}"><i class="fas fa-chart-line"></i>
                        Tabbleau de bord</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="DDgestion" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-tasks"></i> Gestion
                    </a>
                    <div class="dropdown-menu bg-dark" aria-labelledby="DDgestion">
                        <a class="dropdown-item text-white" href="{{ route('organisations.show') }}"><i
                                class="far fa-registered"></i> Gestion des entreprises</a>
                        <a class="dropdown-item text-white" href="{{ route('missions.show') }}"><i
                                class="fas fa-thumbtack"></i> Gestion des missions</a>
                    </div>
                </li>


            </ul>
            <span class="navbar-text">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle img img-fluid"
                                alt="{{ $user->firstname }} {{ $user->lastname }}" width="60px" height="60px"
                                src="{{ $user->picture }}" data-holder-rendered="true"> {{ $user->firstname }}
                            {{ $user->lastname }}
                        </a>
                        <div class="dropdown-menu bg-dark" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('profil') }}"><i class="fas fa-user"></i> Mon
                                profil</a>
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}"><i
                                    class="fas fa-power-off"></i> Déconnexion</a>
                        </div>
                    </li>
                </ul>
            </span>
        </div>
    </nav>

    <div class="container mt-5"> <br></div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="mt-3">
                    @yield('auth.profil.interface.update')
                    @yield('auth.organisation.interface.show')
                    @yield('auth.mission.interface.show')
                    @yield('auth.dashboard.interface.show')


                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div>
            {{-- @yield('auth.intervention.interface.view')
              @yield('auth.dashboard.interface.view')
              @yield('auth.map.interface.view')
              @yield('auth.system.user.view') --}}
        </div>
    </div>

    <div class="text-center bg-dark fixed-bottom text-white">
        {{-- <p class="mt-2">Version {{$last_version->libelle}} ({{$last_version->numero}})</p> --}}
        <p class="mt-2">Copyright 2021 &copy; Hackenathon System</p>
    </div>

</body>

</html>
