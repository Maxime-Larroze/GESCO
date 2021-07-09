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
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav mr-auto">
              @if(!empty($parametre))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}"><i class="fas fa-chart-line"></i>
                        Tableau de bord</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="DDgestion" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-tasks"></i> Gestion
                    </a>
                    <div class="dropdown-menu" aria-labelledby="DDgestion">
                        <a class="dropdown-item" href="{{ route('organisations.show') }}"><i
                                class="far fa-registered"></i> Mes clients</a>
                        <a class="dropdown-item" href="{{ route('missions.show') }}"><i class="fas fa-thumbtack"></i> Mes missions</a>
                        <a class="dropdown-item" href="{{ route('transactions.show') }}"><i class="fas fa-exchange-alt"></i> Mes transactions</a>
                        <a class="dropdown-item" href="{{ route('contributions.show') }}"><i class="fas fa-hand-holding-usd"></i> Mes contributions</a>
                        <a class="dropdown-item" href="{{ route('devis.show') }}"><i class="fas fa-briefcase"></i> Mes devis</a>
                        <a class="dropdown-item" href="{{ route('accomptes.show') }}"><i class="fas fa-money-check-alt"></i> Mes factures d'accompte</a>
                        <a class="dropdown-item" href="{{ route('factures.show') }}"><i class="fas fa-file-invoice-dollar"></i> Mes factures</a>
                    </div>
                </li>
                @endif


            </ul>
            <span class="navbar-text">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle img img-fluid"
                                alt="{{ $user->firstname }} {{ $user->lastname }}" width="30px" height="30px"
                                src="{{ $user->picture }}" data-holder-rendered="true"> {{ $user->firstname }}
                            {{ $user->lastname }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item text-dark" href="{{ route('profil') }}"><i class="fas fa-user"></i> Mon profil</a>
                            <a class="dropdown-item text-primary" href="{{ route('parametres.show') }}"><i class="fas fa-user-cog"></i> Mes paramètres</a>
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}"><i class="fas fa-power-off"></i> Déconnexion</a>

                            {{-- <a class="dropdown-item text-danger">
                              <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button class="btn btn-light dropdown-item text-danger" type="submit"><i class="fas fa-power-off"></i> Déconnexion</button>
                              </form>
                            </a> --}}
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
                    @if(empty($parametre) && !Route::is('parametres.show'))
                        <div class="row">
                          <div class="col-lg-2"></div>
                          <div class="col-lg-8">
                          <h2 class="text-danger text-center">Veuillez paramètrer vos paramètres avant d'utiliser cette application</h2>
                          <p class="mt-5 text-center"><a class="text-primary" href="{{route('parametres.show')}}">Lien de la page de paramètres</a></p>
                          </div>
                          <div class="col-lg-2"></div>
                        </div>
                    @else
                      @yield('auth.organisation.interface.show')
                      @yield('auth.mission.interface.show')
                      @yield('auth.dashboard.interface.show')
                      @yield('auth.facture.interface.show')
                      @yield('auth.transaction.interface.show')
                      @yield('auth.contribution.interface.show')
                      @yield('auth.devis.interface.show')
                      @yield('auth.facture-accompte.interface.show')

                    @endif
                    @yield('auth.parametre.interface.show')
                    @yield('auth.profil.interface.update')
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

    <div class="text-center fixed-bottom">
        <p class="mt-2">Copyright 2021 &copy; Hackenathon System</p>
    </div>

    <script>
        function sortTable(table_id, column_id) {
          var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
          table = document.getElementById(table_id);
          switching = true;
          dir = "asc";
          while (switching) {
            switching = false;
            rows = table.rows;
            for (i = 1; i < (rows.length - 1); i++) {
              shouldSwitch = false;
              x = rows[i].getElementsByTagName("TD")[column_id];
              y = rows[i + 1].getElementsByTagName("TD")[column_id];
              if (dir == "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                  shouldSwitch = true;
                  break;
                }
              } else if (dir == "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                  shouldSwitch = true;
                  break;
                }
              }
            }
            if (shouldSwitch) {
              rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
              switching = true;
              switchcount ++;
            } else {
              if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
              }
            }
          }
        }
        </script>
</body>

</html>
