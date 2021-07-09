@extends('email.template')
@section('email.devis-email.show')
    <title>Devis | Hackenathon-System - {{Crypt::decryptString($parametre->societe_name)}}</title>
</head>
<body>
    <main class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 text-center card">
                <div class="card-body">
                    <div class="text-center">
                        <img src="https://hackenathon-system.ddns.net/uploads/-/system/appearance/logo/1/Hackenathon_System_logo.png"
                            class="img-fluid rounded-circle text-center mb-2" width="132" height="132" />
                            <img src="{{$user->picture}}"
                            class="img-fluid rounded-circle text-center mb-2" width="132" height="132" />
                    </div>
                    <h1>Devis {{$facture->reference}} / {{Crypt::decryptString($parametre->societe_name)}}</h1>
                    <hr>
                    <h4>Message destiné à: {{$client->name}}</h4>
                    <p class="text-center">
                        Vous venez de recevoir votre Devis n°{{$facture->reference}} de la part de la société {{Crypt::decryptString($parametre->societe_name)}}.
                        <br>
                        Vous trouverez en pièce-jointe le document PDF attendu.
                        <br>
                        Si le document en pièce-jointe est illisible, vous pouvez le consulter à <a href="{{URL::signedRoute('signed.exeternal.devis', ['id' => $facture->id, 'user_id'=>$user->id])}}">cette adresse</a>
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
                    <p>Lien de consultation de votre devis: {{URL::signedRoute('signed.exeternal.devis', ['id' => $facture->id, 'user_id'=>$user->id])}}</p>
                    <br><br>
                    <p class="mt-5 font-weight-light font-italic">Message envoyé automatiquement par le système de gestion commerciale <a href="https://hackenathon-system.ddns.net:35003">Hackenathon-System</a></p>
                </div>
            </div>
        </div>
    </main>
@endsection