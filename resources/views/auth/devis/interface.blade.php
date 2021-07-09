@extends('auth.template')
@section('auth.devis.interface.show')
    <div class="row mt-2">
        <h3 class="text-center">Devis</h3>
        <hr>
        <table class="table table-responsive-sm table-responsive-md table-responsive-lg table-responsive-xl table-hover table-striped mb-5 text-center mt-2" id="devis_table">
            <thead class="thead-light">
                <tr>
                    <th onclick="sortTable('devis_table', 0)">Référence</th>
                    <th onclick="sortTable('devis_table', 1)">Titre</th>
                    <th onclick="sortTable('devis_table', 2)">Organisation</th>
                    <th onclick="sortTable('devis_table', 3)">Signature</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
            @if($missions->isEmpty())
                    </tbody>
                </table>
                <h2 class="text-center">Aucun devis disponible</h2>
            @else
                @foreach ($missions as $mission)
                    <tr>
                        <td>{{ $mission->reference }}</td>
                        <td>{{ $mission->title }}</td>
                        @foreach ($organisations as $organisation)
                            @if ($mission->organisation_id === $organisation->id)
                                <td>{{ $organisation->name }}</td>
                            @endif
                        @endforeach
                        @if (!empty($mission->signated_at))
                            <td>{{ date('d-m-Y H:i', strtotime($mission->signated_at)) }}</td>
                        @else
                            <td class="text-danger font-weight-bold">Non signé</td>
                        @endif
                        <td>
                            <div class="row">
                                <div class="col-lg-6"><a href="{{route('devis.pdf.show', $mission->id)}}"><button class="btn btn-info form-check-inline" type="button">
                                    <i class="fas fa-file-invoice"></i> Voir</button></a></div>
                                <div class="col-lg-6">
                                    <form class="form-check-inline" action="{{ route('email.devis.send') }}"method="POST">
                                        @csrf 
                                        <input type="hidden" name="mission_id"value="{{ $mission->id }}">
                                        <input type="hidden" name="client_id"value="{{ $mission->organisation_id }}">
                                        <button class="btn btn-primary" type="submit"><i class="fas fa-at"></i> Envoyer</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                </table>
            @endif
    </div>
@endsection