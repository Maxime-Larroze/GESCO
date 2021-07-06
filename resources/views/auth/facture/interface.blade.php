@extends('auth.template')
@section('auth.facture.interface.show')
    <div class="row mt-2">
        <h3 class="text-center">Factures</h3>
        <hr>
        <table class="table table-hover table-striped mb-5 text-center mt-2" id="facture_table">
            <thead class="thead-light">
                <tr>
                    <th onclick="sortTable('facture_table', 0)">Référence</th>
                    <th onclick="sortTable('facture_table', 1)">Titre</th>
                    <th onclick="sortTable('facture_table', 2)">Organisation</th>
                    <th onclick="sortTable('facture_table', 3)">Terminé</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($missions as $mission)
                @if(!empty($mission->ended_at) && $mission->ended_at != null)
                    <tr>
                        <td>{{ $mission->reference }}</td>
                        <td>{{ $mission->title }}</td>
                        @foreach ($organisations as $organisation)
                            @if ($mission->organisation_id === $organisation->id)
                                <td>{{ $organisation->name }}</td>
                            @endif
                        @endforeach
                        @if (!empty($mission->ended_at))
                            <td>{{ date('d-m-Y H:i', strtotime($mission->ended_at)) }}</td>
                        @else
                            <td class="text-danger">Non terminé</td>
                        @endif
                        <td>
                            <div class="row">
                                <div class="col-lg-6"><button class="btn btn-warning form-check-inline" type="button"
                                        data-toggle="modal" data-target="#ModalMission{{ $mission->id }}"><i
                                            class="fas fa-edit"></i> Editer</button></div>
                                <div class="col-lg-6">
                                    <form class="form-check-inline" action="{{ route('missions.destroy') }}"
                                        method="POST">@csrf @method('DELETE') <input type="hidden" name="mission_id"
                                            value="{{ $mission->id }}"> <button class="btn btn-danger"
                                            type="submit"><i class="far fa-trash-alt"></i> Supprimer</button></form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>
@endsection