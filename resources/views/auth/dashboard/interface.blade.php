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
            <h2>Mission(s) en cours</h2>
            <table class="table table-hover table-striped mb-5 text-center mt-2">
                <thead class="thead-light">
                    <tr>
                        <th>Référence</th>
                        <th>Titre</th>
                        <th>Organisation</th>
                        <th>Terminé</th>
                    </tr>
                </thead>
                @if(Empty($endMissions))
                <h2 class="text-center">Aucune mission en cours</h2>
                @else
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
                @endif
            </table>
        </div>
        <div class="col-lg-12 text-center">
            <hr>
            <h2>Mission(s) terminée(s)</h2>
            <table class="table table-hover table-striped mb-5 text-center mt-2">
                <thead class="thead-light">
                    <tr>
                        <th>Référence</th>
                        <th>Titre</th>
                        <th>Organisation</th>
                        <th>Crée le</th>
                    </tr>
                </thead>
                @if(Empty($nbMissionEnCours))
                <h2 class="text-center">Aucune mission terminée</h2>
                @else
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
                @endif
            </table>
        </div>
    </div>
@endsection
