@extends('auth.template')
@section('auth.mission.interface.show')
    <script>
        function calculate(id_total, id_quantite, id_unite) {
            document.getElementById(id_total).textContent = Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(
                document.getElementById(id_quantite).value * document.getElementById(id_unite).value
            );
        }
        function trash(id_table, id_row) {
            document.getElementById(id_table).deleteRow(id_row);
        }
    </script>
    <div class="row mt-2">
        <div class="col-lg-12 text-center">
            <h3 class="text-center">Liste des missions</h3>
            <hr>
            <a data-toggle="modal" data-target="#NewModalMission"><button class="btn btn-success"><i
                        class="far fa-plus-square"></i> Créer une nouvelle mission</button></a>
            <table class="table table-responsive-sm table-responsive-md table-responsive-lg table-responsive-xl table-hover table-striped mb-5 text-center mt-2" id="mission_Table">
                <thead class="thead-light">
                    <tr>
                        <th><span onclick="sortTable('mission_Table', 0)">Référence</span></th>
                        <th><span onclick="sortTable('mission_Table', 1)">Titre</span></th>
                        <th><span onclick="sortTable('mission_Table', 2)">Organisation</span></th>
                        <th><span onclick="sortTable('mission_Table', 3)">Etat</span></th>
                        <th>Options</th>
                    </tr>
                </thead>
                @if($missions->isEmpty())
                </tbody>
            </table>
            <h3 class="text-center">Aucune mission enregistrée</h3>
                @else
                <tbody>
                    @foreach ($missions as $mission)
                        <tr>
                            <td>{{ $mission->reference }}</td>
                            <td>{{ $mission->title }}</td>
                            @foreach ($organisations as $organisation)
                                @if ($mission->organisation_id === $organisation->id)
                                    <td>{{ $organisation->name }}</td>
                                @endif
                            @endforeach
                            <td>
                                @if (!empty($mission->signed_at) && !empty($mission->deposed_at && !empty($mission->ended_at)))
                                    {{ date('d-m-Y H:i', strtotime($mission->ended_at)) }}
                                @elseif(!empty($mission->signed_at) && !empty($mission->deposed_at && empty($mission->ended_at)))
                                <span class="text-primary font-weight-bold">Mission en cours</span>
                                @elseif(!empty($mission->signed_at) && empty($mission->deposed_at && empty($mission->ended_at)))
                                <span class="text-warning font-weight-bold">En attente de dépôt</span>
                                @elseif(empty($mission->signed_at) && empty($mission->deposed_at && empty($mission->ended_at)))
                                    <span class="text-danger font-weight-bold">En attente signature</span>
                                @else
                                    <span class="text-danger font-weight-bold">En attente</span>
                                @endif
                            </td> 
                            <td>
                                <div class="row">
                                    <div class="col-lg-6"><button class="btn btn-warning form-check-inline" type="button"
                                            data-toggle="modal" data-target="#ModalMission{{ $mission->id }}"><i
                                                class="fas fa-edit"></i></button></div>
                                    <div class="col-lg-6">
                                        <form class="form-check-inline" action="{{ route('missions.destroy') }}"
                                            method="POST">@csrf @method('DELETE') <input type="hidden" name="mission_id"
                                                value="{{ $mission->id }}"> <button class="btn btn-danger"
                                                type="submit"><i class="far fa-trash-alt"></i></button></form>
                                    </div>
                                </div>
                                <div class="modal" id="ModalMission{{ $mission->id }}">
                                    <div class="modal-dialog modal-xl modal-dialog-centered">
                                        <div class="modal-content">
                                            <form action="{{ route('missions.update') }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="mission_id" value="{{ $mission->id }}">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Modification de la mission
                                                        [{{ $mission->title }}]</h4>
                                                    <button type="button" class="close"
                                                        data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body row">
                                                    <div class="mt-3 col-md-12 input-group input-group-ml">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text text-danger"><i
                                                                    class="fas fa-fingerprint"></i></span>
                                                        </div>
                                                        <input type="text" name="reference" value="{{ $mission->reference }}"
                                                            class="input-group form-control" disabled>
                                                    </div>
                                                    <div class="mt-3 col-md-6 input-group input-group-ml">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text text-danger"><i
                                                                    class="fas fa-heading"></i></span>
                                                        </div>
                                                        <input type="text" name="title" value="{{ $mission->title }}"
                                                            class="input-group form-control"
                                                            placeholder="Titre de la mission" required>
                                                    </div>
                                                    <div class="mt-3 col-md-6 input-group input-group-ml">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text text-danger"><i
                                                                    class="fas fa-euro-sign"></i></span>
                                                        </div>
                                                        <input type="number"
                                                            value="{{ $mission->deposit }}"
                                                            class="input-group form-control" placeholder="Montant du dépot"
                                                            disabled>
                                                    </div>
                                                    <div class="mt-3 col-md-6 input-group input-group-ml">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text text-danger"><i
                                                                    class="far fa-registered"></i></span>
                                                        </div>
                                                        <select name="organisation_id" class="custom-select" required>
                                                            @foreach ($organisations as $organisation)
                                                                @if ($mission->organisation_id === $organisation->id)
                                                                    <option value="{{ $organisation->id }}" selected>
                                                                        {{ $organisation->name }}</option>
                                                                @else
                                                                    <option value="{{ $organisation->id }}">
                                                                        {{ $organisation->name }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mt-3 col-md-6  text-center">
                                                        <div class="mt-3 input-group form-group input-group-ml">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text text-danger">Signature le</span>
                                                            </div>
                                                            <input type="date" class="input-group form-control" name="signed_at" value="{{Carbon\Carbon::parse($mission->signed_at)->format('Y-m-d')}}">
                                                        </div>
                                                    </div>
                                                    <div class="mt-3 col-md-6  text-center">
                                                        <div class="mt-3 input-group form-group input-group-ml">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text text-danger">Dépôt fait le</span>
                                                            </div>
                                                            <input type="date" class="input-group form-control" name="deposed_at" value="{{Carbon\Carbon::parse($mission->deposed_at)->format('Y-m-d')}}">
                                                        </div>
                                                    </div>
                                                    <div class="mt-3 col-md-6  text-center">
                                                        <label class="form-check-label">
                                                                <input type="checkbox" class="form-check-input"
                                                                    name="ended_at" value="0" @if (!empty($mission->ended_at)) checked @endif> Mission terminé
                                                        </label>
                                                    </div>
                                                    <div class="mt-3 col-md-6 form-group input-group input-group-ml">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text text-danger"><i
                                                                    class="fas fa-comment-medical"></i></span>
                                                        </div>
                                                        <textarea class="form-control" rows="5"
                                                            placeholder="Commentaire sur la mission"
                                                            name="comment">{{ $mission->comment }}</textarea>
                                                    </div>
                                                    @php $tmp = 0; @endphp
                                                    <div class="mt-3 col-md-6 input-group input-group-ml">
                                                        <p onclick="tabFonction_{{ str_replace('-', '', $mission->id) }}()">
                                                            Ajouter une nouvelle
                                                            ligne <span id="add_new_line"><i
                                                                    class="far fa-plus-square"></i></span>
                                                        </p>
                                                    </div>
                                                    <script>
                                                        var temp = {{$tmp}};
                                                        function tabFonction_{{str_replace('-', '', $mission->id) }}() {
                                                            const table = document.getElementById("MissionTab{{ str_replace('-', '', $mission->id) }}");
                                                            const row = table.insertRow(1);
                                                            const cell1 = row.insertCell(0);
                                                            const cell2 = row.insertCell(1);
                                                            const cell3 = row.insertCell(2);
                                                            const cell4 = row.insertCell(3);
                                                            const cell5 = row.insertCell(4);
                                                            const cell6 = row.insertCell(5);
                                                            cell1.innerHTML = '<input type="text" placeholder="Titre tâche" class="btn" name="title_missionline_A['+temp+']" id="title_missionline_A['+temp+']">'
                                                            cell2.innerHTML = `<input type="text" placeholder="Quantité tâche" class="btn" name="quantity_missionline_A[`+temp+`]" id="quantity_missionline_A[`+temp+`]" 
                                                            onchange=calculate('total_missionline_A[`+temp+`]','quantity_missionline_A[`+temp+`]','price_missionline_A[`+temp+`]') >`
                                                            cell3.innerHTML = `<input type="text" placeholder="Prix tâche" class="btn" name="price_missionline_A[`+temp+`]" id="price_missionline_A[`+temp+`]" 
                                                            onchange=calculate('total_missionline_A[`+temp+`]','quantity_missionline_A[`+temp+`]','price_missionline_A[`+temp+`]') >`
                                                            cell4.innerHTML = '<input type="text" placeholder="Unité tâche" class="btn" name="unity_missionline_A['+temp+']" id="unity_missionline_A['+temp+']">'
                                                            cell5.innerHTML = '<span id="total_missionline_A['+temp+']" aria-disabled="true" id="total_missionline_A['+temp+']"> 0.00 </span>';
                                                            temp++;
                                                        } 
                                                    </script>
                                                    <div class="mt-3 col-md-12">
                                                        <table class="table table-responsive-sm table-responsive-md table-responsive table-hover table-striped mb-5 text-center mt-2"
                                                            id="MissionTab{{ str_replace('-', '', $mission->id) }}">
                                                            <thead class="thead-light">
                                                                <tr>
                                                                    <th>Titre</th>
                                                                    <th>Quantité</th>
                                                                    <th>Prix</th>
                                                                    <th>Unité</th>
                                                                    <th>Total</th>
                                                                    <th>Option</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($missionLines as $missionLine)
                                                                    @if ($missionLine->mission_id === $mission->id)
                                                                        <tr>
                                                                            <td><input type="text" class="btn"
                                                                                    name="title_missionline_B[{{ $tmp }}]"
                                                                                    id="title_missionline_B{{ $missionLine->id }}"
                                                                                    value="{{ $missionLine->title }}">
                                                                                    <input type="hidden" name="missionLine_id_[{{ $tmp }}]" value="{{ $missionLine->id }}" />
                                                                            </td>
                                                                            <td><input type="text" class="btn"
                                                                                    name="quantity_missionline_B[{{ $tmp }}]"
                                                                                    id="quantity_missionline_B{{ $missionLine->id }}"
                                                                                    value="{{ $missionLine->quantity }}"
                                                                                    onchange="calculate('total_missionline_B{{ $missionLine->id }}','quantity_missionline_B{{ $missionLine->id }}','price_missionline_B{{ $missionLine->id }}')"
                                                                            </td>
                                                                            <td><input type="text" class="btn"
                                                                                    name="price_missionline_B[{{ $tmp }}]"
                                                                                    id="price_missionline_B{{ $missionLine->id }}"
                                                                                    value="{{ $missionLine->price }}"
                                                                                    onchange="calculate('total_missionline_B{{ $missionLine->id }}','quantity_missionline_B{{ $missionLine->id }}','price_missionline_B{{ $missionLine->id }}')"
                                                                            </td>
                                                                            <td><input type="text" class="btn"
                                                                                    name="unity_missionline_B[{{ $tmp }}]"
                                                                                    id="unity_missionline_B{{ $missionLine->id }}"
                                                                                    value="{{ $missionLine->unity }}">
                                                                            </td>
                                                                            <td><span
                                                                                    id="total_missionline_B{{ $missionLine->id }}"
                                                                                    aria-disabled="true">{{number_format($missionLine->price * $missionLine->quantity, 2) }} €</span></td>
                                                                            <td><span onclick="trash('MissionTab{{ str_replace('-', '', $mission->id) }}', '{{ $tmp+1 }}')"><i class="fas fa-trash-alt text-danger"></i></span></td>
                                                                        </tr>
                                                                        @php $tmp++; @endphp
                                                                    @endif
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success"><i
                                                            class="fas fa-check"></i> Valider</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
                @endif
        </div>
    </div>

    <div class="modal" id="NewModalMission">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('missions.create') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Création d'une mission</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body row">
                        <div class="mt-3 col-md-6 input-group input-group-ml">
                            <div class="input-group-prepend">
                                <span class="input-group-text text-danger"><i class="fas fa-heading"></i></span>
                            </div>
                            <input type="text" name="title" value="{{ old('title') }}" class="input-group form-control"
                                placeholder="Titre de la mission" required>
                        </div>
                        <div class="mt-3 col-md-6 input-group input-group-ml">
                            <div class="input-group-prepend">
                                <span class="input-group-text text-danger"><i class="far fa-registered"></i></span>
                            </div>
                            <select name="organisation_id" class="custom-select" required>
                                @foreach ($organisations as $organisation)
                                    <option value="{{ $organisation->id }}">{{ $organisation->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-3 col-md-6 form-group input-group input-group-ml">
                            <div class="input-group-prepend">
                                <span class="input-group-text text-danger"><i class="fas fa-comment-medical"></i></span>
                            </div>
                            <textarea class="form-control" rows="5" placeholder="Commentaire sur la mission"
                                name="comment">{{ old('comment') }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Valider</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection