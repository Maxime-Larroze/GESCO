@extends('auth.template')
@section('auth.facture-accompte.interface.show')
    <div class="row mt-2">
        <h3 class="text-center">Factures d'accomptes</h3>
        <hr>
        <table class="table table-responsive-sm table-responsive-md table-responsive-lg table-responsive-xl table-hover table-striped mb-5 text-center mt-2" id="facture_table">
            <thead class="thead-light">
                <tr>
                    <th onclick="sortTable('facture_table', 0)">Référence</th>
                    <th onclick="sortTable('facture_table', 1)">Mission</th>
                    <th onclick="sortTable('facture_table', 2)">Organisation</th>
                    <th onclick="sortTable('facture_table', 3)">Versé le</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
            @if($missions->isEmpty())
                    </tbody>
                </table>
                <h2 class="text-center">Aucune facture d'accompte disponible</h2>
            @else
                @foreach ($missions as $mission)
                    @if(!empty($mission->ended_at) && $mission->ended_at != null)
                        <tr>
                            <td>{{ $mission->reference }}</td>
                            <td>{{ $mission->title }}</td>
                            <td>
                                @foreach ($organisations as $organisation)
                                    @if ($mission->organisation_id === $organisation->id)
                                        {{ $organisation->name }}
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                @if (!empty($mission->deposed_at))
                                    {{ date('d-m-Y', strtotime($mission->deposed_at)) }}
                                @else
                                    <span class="text-danger font-weight-bold">Non versé</span>
                                @endif
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-lg-6"><a href="{{route('accomptes.pdf.show', $mission->id)}}"><button class="btn btn-info form-check-inline" type="button">
                                        <i class="fas fa-file-invoice"></i> Voir</button></a></div>
                                    <div class="col-lg-6">
                                        <form class="form-check-inline" action="{{ route('email.accomptes.send') }}"method="POST">
                                            @csrf 
                                            <input type="hidden" name="mission_id"value="{{ $mission->id }}">
                                            <input type="hidden" name="client_id"value="{{ $mission->organisation_id }}">
                                            <button class="btn btn-primary" type="submit"><i class="fas fa-at"></i> Envoyer</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
                </table>
            @endif
    </div>
@endsection