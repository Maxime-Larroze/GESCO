@extends('auth.template')
@section('auth.dashboard.interface.show')
    <div class="row mt-2">
        <h3 class="text-center">Tableau de bord</h3>
        <div class="col-lg-4 text-white">
            <div class="card bg-success">
                <div class="card-body text-center">
                <p class="card-text">Mission(s) terminée(s)</p>
                <h3>{{$nbMissionTermine}}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-4 text-white">
            <div class="card bg-primary">
                <div class="card-body text-center">
                <p class="card-text">Entreprise(s) enregistrée(s)</p>
                <h3>{{count($organisations)}}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-4 text-white">
            <div class="card bg-warning">
                <div class="card-body text-center">
                <p class="card-text">Mission(s) en cours</p>
                <h3>{{$nbMissionEnCours}}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-12 text-center">
            <hr>
            <h2>Mission(s) terminée(s)</h2>
            <table class="table table-hover table-striped mb-5 text-center mt-2" id="mission_termine_table">
                <thead class="thead-light">
                    <tr>
                        <th onclick="sortTable('mission_termine_table', 0)">Référence</th>
                        <th onclick="sortTable('mission_termine_table', 1)">Titre</th>
                        <th onclick="sortTable('mission_termine_table', 2)">Organisation</th>
                        <th onclick="sortTable('mission_termine_table', 3)">Terminée le</th>
                    </tr>
                </thead>
                @if(!$endMissions->isEmpty())
                <tbody>
                    @foreach ($endMissions as $endMission)
                    <tr>
                        <td>{{$endMission->reference}}</td>
                        <td>{{$endMission->title}}</td>
                        <td>
                            @foreach($organisations as $organisation)
                                @if($organisation->id === $endMission->organisation_id)
                                    {{$endMission->organisation_id}}
                                @endif
                            @endforeach
                        </td>
                        <td>{{$endMission->ended_at}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
                @else
            </tbody>
            </table>
                <h2 class="text-center">Aucune mission terminée</h2>
                @endif
        </div>
        <div class="col-lg-12 text-center mt-5">
            <hr>
            <h2>Mission(s) en cours</h2>
            <table class="table table-hover table-striped mb-5 text-center mt-2" id="mission_encours_table">
                <thead class="thead-light">
                    <tr>
                        <th onclick="sortTable('mission_encours_table', 0">Référence</th>
                        <th onclick="sortTable('mission_encours_table', 1">Titre</th>
                        <th onclick="sortTable('mission_encours_table', 2">Organisation</th>
                        <th onclick="sortTable('mission_encours_table', 3">Crée le</th>
                    </tr>
                </thead>
                @if(!$MissionEnCours->isEmpty())
                    <tbody>
                        @foreach ($MissionEnCours as $MissionEnCour)
                        <tr>
                            <td>{{$MissionEnCour->reference}}</td>
                            <td>{{$MissionEnCour->title}}</td>
                            <td>
                                @foreach($organisations as $organisation)
                                    @if($organisation->id === $MissionEnCour->organisation_id)
                                        {{$MissionEnCour->organisation_id}}
                                    @endif
                                @endforeach
                            </td>
                            <td>{{$MissionEnCour->created_at}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                </table>
                <h2 class="text-center">Aucune mission en cours</h2>
            @endif
        </div>
    </div>
@endsection