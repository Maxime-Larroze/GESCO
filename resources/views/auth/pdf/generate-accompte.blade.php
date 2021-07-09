<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{ $mission->title }}">
    <meta name="author" content="{{ $organisation->name }}">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="{{ asset('img/logo/Hackenathon_System_logo.png') }}" />

    <script src="https://unpkg.com/boxicons@latest/dist/boxicons.js"></script>
    <title>GESCO | Hackenathon-System</title>

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
    @php
        $total_ttc = 0;
        $total_ht = 0;
        $total_tva = 0;
        $total_transac = 0;
    @endphp
    <main class="content">
        @if (Route::is('accomptes.pdf.show'))
            <div class="col-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-2">
                <a href="{{ URL::previous() }}"><i class="fas fa-arrow-left"></i> Revenir en
                    arrière</a>
            </div>
        @endif
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body m-sm-3 m-md-5">
                            <div class="row">
                                <div class="col-5 col-md-5 col-lg-5 col-xl-5 col-xxl-5">
                                    <div class="text-muted">Mission N° </div>
                                    <strong>{{ $mission->reference }}</strong>
                                </div>
                                <div class="col-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2 text-center">
                                    <p>Facture d'accompte
                                        <br>
                                        <strong>{{ $mission->title }}</strong>
                                    </p>
                                </div>
                                <div class="col-5 col-md-5 col-lg-5 col-xl-5 col-xxl-5 text-md-end">
                                    <div class="text-muted">Date de création</div>
                                    <strong>{{ Carbon\Carbon::parse($mission->created_at)->format('d-m-Y à H:i') }}</strong>
                                </div>
                            </div>

                            <hr class="my-4" />

                            <div class="row mb-4">
                                <div class="col-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                                    <div class="text-muted">Client</div>
                                    <strong>
                                        {{ $organisation->name }}
                                    </strong>
                                        {{ $organisation->adresse }}
                                        <br>
                                        N° SIRET: {{ $organisation->siret ?? 'N/A' }}
                                        <br>
                                        <a href="mailto:{{ $organisation->email }}">
                                            {{ $organisation->email }}
                                        </a>
                                        <br>
                                        <a href="tel:{{ $organisation->tel }}">
                                            {{ $organisation->tel }}
                                        </a>
                                    </p>
                                </div>
                                <div class="col-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6 text-md-end">
                                    <div class="text-muted"> Prestataire</div>
                                    <strong>
                                        {{ Crypt::decryptString($parametre->societe_name) }}
                                    </strong>
                                    <p><strong>{{ $user->firstname }} {{ $user->lastname }}</strong>
                                        <br>
                                        {{ Crypt::decryptString($parametre->adresse) }}, {{ Crypt::decryptString($parametre->domiciliation) }}
                                        <br>
                                        N° SIRET: {{ Crypt::decryptString($parametre->siret) ?? 'N/A' }}
                                        <br>
                                        <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                    </p>
                                </div>

                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Tâche(s)</th>
                                            <th>Quantité</th>
                                            <th>Montant PUTTC</th>
                                            <th>Total TTC</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($missionLines as $missionLine)
                                            <tr>
                                                <td class="font-weight-bold">{{ $missionLine->title }}</td>
                                                <td>{{ $missionLine->quantity }}</td>
                                                <td>{{ number_format($missionLine->price, 2, ',', ' ') }}</td>
                                                <td>{{ number_format($missionLine->quantity * $missionLine->price, 2, ',', ' ') }} €</td>
                                            </tr>
                                            @php
                                                $total_ttc += $missionLine->quantity * $missionLine->price;
                                            @endphp
                                        @endforeach
                                        <tr>
                                            <th>&nbsp;</th>
                                            <th>&nbsp;</th>
                                            <th>Total TTC</th>
                                            <th>{{ number_format($total_ttc, 2, ',', ' ') }} €</th>
                                        </tr>
                                        <tr>
                                            <th>&nbsp;</th>
                                            <th>&nbsp;</th>
                                            <th>Accompte en %</th>
                                            <th>45%</th>
                                        </tr>
                                        <tr>
                                            <th>&nbsp;</th>
                                            <th>&nbsp;</th>
                                            <th>Accompte en €</th>
                                            <th>{{number_format($total_ttc*0.45, 2, ',', ' ')}} €</th>
                                        </tr>
                                        <tr>
                                            <th>&nbsp;</th>
                                            <th>&nbsp;</th>
                                            <th>Reste à payer</th>
                                            <th>{{number_format($total_ttc-$total_ttc*0.45, 2, ',', ' ')}} €</th>
                                        </tr>
                                        <tr>
                                            <th>&nbsp;</th>
                                            <th>&nbsp;</th>
                                            <th>Date encaissement</th>
                                            <th>
                                                @if(!empty($mission->ended_at) && $mission->ended_at != null)
                                                {{date('d-m-Y H:i', strtotime($mission->ended_at))}}
                                                @else
                                                Non encaissé
                                                @endif
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>&nbsp;</th>
                                            <th>&nbsp;</th>
                                            <th>Devis signé le</th>
                                            <th>
                                                @if(!empty($mission->signed_at))
                                                {{Carbon\Carbon::parse($mission->signed_at)->format('d-m-Y')}}
                                                @else
                                                Non signé
                                                @endif
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>&nbsp;</th>
                                            <th>&nbsp;</th>
                                            <th>Accompte versé le</th>
                                            <th>
                                                @if(!empty($mission->deposed_at))
                                                {{Carbon\Carbon::parse($mission->deposed_at)->format('d-m-Y')}}
                                                @else
                                                Non versé 
                                                @endif
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>

                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Nom de la mission</th>
                                            <th>Montant en €</th>
                                            <th>Date de versement</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transactions as $transaction)
                                            @if($transaction->source_id == $mission->id)
                                                <tr>
                                                    <td>{{ $mission->title }}</td>
                                                    <td>{{ number_format($transaction->price, 2, ',', ' ') }}</td>
                                                    <td>{{ Carbon\Carbon::parse($transaction->payed_at)->format('d-m-Y') }}</td>
                                                </tr>
                                                @php $total_transac += $transaction->price; @endphp
                                            @endif
                                        @endforeach
                                        <tr>
                                            <th>&nbsp;</th>
                                            <th>Total transaction</th>
                                            <th>{{ number_format($total_transac, 2, ',', ' ') }} €</th>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="col-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6 border">
                                    <p class="text-center">{{$user->firstname}} {{$user->lastname}} certifie avoir bien reçut l'accompte du client {{ $organisation->name }} le {{Carbon\Carbon::parse($mission->deposed_at)->format('d/m/Y')}} d'un motant de {{number_format($total_transac, 2, ',', ' ')}} €.</p>
                                    <p>Date de la signature:</p>
                                    <p>Signature du client:</p>
                                   <div class="mt-5 mb-5"></div>
                                </div>
                                <div class="col-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                                    <p class="text-sm">
                                        <strong>Note:</strong> {{Crypt::decryptString($parametre->mention_a)}}
                                        <hr>
                                        {{Crypt::decryptString($parametre->mention_b)}}
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            @if (Route::is('accomptes.pdf.show'))
                <div class="col-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 text-center mt-5">
                    <a href="{{ route('devis.pdf.store', $mission->id) }}">
                        <button class="btn btn-primary mb-5">Télécharger cette facture d'accompte</button></a>
                </div>
            @endif
        </div>
    </main>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>
