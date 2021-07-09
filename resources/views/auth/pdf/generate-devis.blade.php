@extends('auth.pdf.template')
@section('auth.pdf.generate-devis.show')
    <meta name="description" content="{{ $mission->title }}">
    <meta name="author" content="{{ $organisation->name }}">
</head>
<body>
    @php
        $total_ttc = 0;
        $total_ht = 0;
        $total_tva = 0;
    @endphp
    <main class="content">
        @if (Route::is('devis.pdf.show'))
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
                                    <p>Intitulé du devis
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
                                <div class="col-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6 border">
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
            @if (Route::is('devis.pdf.show'))
                <div class="row">
                    <div class="col-4 col-md-4 col-lg-4 col-xl-4 col-xxl-4 text-center mt-5">
                        <a href="{{ route('devis.pdf.store', $mission->id) }}">
                            <button class="btn btn-primary mb-5"><i class="fas fa-download"></i> Télécharger ce devis</button></a>
                    </div>
                    <div class="col-4 col-md-4 col-lg-4 col-xl-4 col-xxl-4 text-center mt-5">
                        <button class="btn btn-dark mb-5" onclick="share('{{URL::signedRoute('signed.exeternal.devis', ['id' => $mission->id, 'user_id'=>$user->id])}}')"><i class="far fa-share-square"></i> Partager le lien sécurisé</button>
                    </div>
                    <div class="col-4 col-md-4 col-lg-4 col-xl-4 col-xxl-4 text-center mt-5">
                        <button class="btn btn-danger mb-5" onclick="imprimer()"><i class="fas fa-print"></i> Imprimer ce devis</button>
                    </div>
                </div>
            @endif
        </div>
    </main>
@endsection