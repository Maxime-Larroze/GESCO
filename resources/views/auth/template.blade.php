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

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.css" rel="stylesheet" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.js"></script>

</head>

<body class="antialiased">
    <nav class="navbar navbar-expand-lg  navbar-light fixed-top">
        <a class="navbar-brand text-danger" href="{{ route('dashboard') }}">Hackenathon System</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav mr-auto">
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
                        <a class="dropdown-item" href="{{ route('missions.show') }}"><i
                                class="fas fa-thumbtack"></i> Mes missions</a>
                        <a class="dropdown-item" href="{{ route('factures.show') }}"><i class="fas fa-file-invoice-dollar"></i> Mes devis</a>
                        <a class="dropdown-item" href="{{ route('factures.show') }}"><i class="fas fa-file-invoice-dollar"></i> Mes factures d'accompte</a>
                        <a class="dropdown-item" href="{{ route('factures.show') }}"><i class="fas fa-file-invoice-dollar"></i> Mes factures</a>
                    </div>
                </li>


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
                            <a class="dropdown-item text-dark" href="{{ route('profil') }}"><i class="fas fa-user"></i> Mon
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
                    @yield('auth.facture.interface.show')

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
          // Set the sorting direction to ascending:
          dir = "asc";
          /* Make a loop that will continue until
          no switching has been done: */
          while (switching) {
            // Start by saying: no switching is done:
            switching = false;
            rows = table.rows;
            /* Loop through all table rows (except the
            first, which contains table headers): */
            for (i = 1; i < (rows.length - 1); i++) {
              // Start by saying there should be no switching:
              shouldSwitch = false;
              /* Get the two elements you want to compare,
              one from current row and one from the next: */
              x = rows[i].getElementsByTagName("TD")[column_id];
              y = rows[i + 1].getElementsByTagName("TD")[column_id];
              /* Check if the two rows should switch place,
              based on the direction, asc or desc: */
              if (dir == "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                  // If so, mark as a switch and break the loop:
                  shouldSwitch = true;
                  break;
                }
              } else if (dir == "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                  // If so, mark as a switch and break the loop:
                  shouldSwitch = true;
                  break;
                }
              }
            }
            if (shouldSwitch) {
              /* If a switch has been marked, make the switch
              and mark that a switch has been done: */
              rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
              switching = true;
              // Each time a switch is done, increase this count by 1:
              switchcount ++;
            } else {
              /* If no switching has been done AND the direction is "asc",
              set the direction to "desc" and run the while loop again. */
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
