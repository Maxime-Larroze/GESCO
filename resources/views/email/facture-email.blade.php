<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Gesco Hackenathon-System">
    <meta name="author" content="Maxime LARROZE-F.">
    <meta name="keywords" content="Hackenathon-System Gestion Commerciale">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="{{ asset('/img/Hackenathon_System_logo.png') }}" />

    <script src="https://unpkg.com/boxicons@latest/dist/boxicons.js"></script>
    <title>Facture | Hackenathon-System - {{Crypt::decryptString($parametre->societe_name)}}</title>

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
<body>
    <main class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 text-center card">
                <div class="card-body">
                    <div class="text-center">
                        <img src="{{ asset('/img/Hackenathon_System_logo.png') }}"
                            class="img-fluid rounded-circle text-center mb-2" width="132" height="132" />
                            <img src="{{$user->picture}}"
                            class="img-fluid rounded-circle text-center mb-2" width="132" height="132" />
                    </div>
                    <h1>Facture {{$facture->reference}} / {{Crypt::decryptString($parametre->societe_name)}}</h1>
                    <hr>
                    <h4>Message destiné à: {{$client->name}}</h4>
                    <p class="text-center">
                        Vous venez de recevoir votre Devis/Facture n°{{$facture->reference}} de la part de la société {{Crypt::decryptString($parametre->societe_name)}}.
                        <br>
                        Vous trouverez en pièce-jointe le document PDF attendu.
                        <br>
                        Si le document en pièce-jointe est illisible, vous pouvez le consulter à <a href="{{URL::signedRoute('signed.exeternal.facture', ['id' => $facture->id])}}">cette adresse</a>
                        <br>
                    </p>
                    <p class="mb-5">
                        Cordialement,
                        <br>
                        {{$user->firstname}} {{$user->lastname}} / <a href="mailto:{{$user->email}}">{{$user->email}}</a>
                        <br>
                        Société {{Crypt::decryptString($parametre->societe_name)}}
                        <br>
                        {{Crypt::decryptString($parametre->adresse)}} - {{Crypt::decryptString($parametre->domiciliation)}}
                    </p>
                    <p>Lien de consultation de votre devis/facture: {{URL::signedRoute('signed.exeternal.facture', ['id' => $facture->id])}}</p>
                    <br><br><br>
                    <p class="mt-5 font-weight-light font-italic">Message envoyé automatiquement par le système de gestion commerciale <a href="https://hackenathon-system.ddns.net:35003">Hackenathon-System</a></p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>