@extends('auth.dashboard')
@section('auth.mission.interface.show')
    <script>
        function calculate(id_total, id_quantite, id_unite) {
            document.getElementById(id_total).textContent = document.getElementById(id_quantite)
                .value *
                document.getElementById(id_unite).value;
        }
    </script>
    <div class="row mt-2">
        <div class="col-lg-12 text-center">
            <h3 class="text-center">Liste des missions</h3>
            <hr>
            <a data-toggle="modal" data-target="#NewModalMission"><button class="btn btn-success"><i
                        class="far fa-plus-square"></i> Créer une nouvelle mission</button></a>
            <table class="table table-hover table-striped mb-5 text-center mt-2">
                <thead class="thead-light">
                    <tr>
                        <th>Référence</th>
                        <th>Titre</th>
                        <th>Organisation</th>
                        <th>Terminé</th>
                        <th>Options</th>
                    </tr>
                </thead>
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
                                <div class="modal" id="ModalMission{{ $mission->id }}">
                                    <div class="modal-dialog modal-xl modal-dialog-centered">
                                        <div class="modal-content">
                                            <form action="{{ route('organisations.update') }}" method="POST">
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
                                                        <input type="text" value="{{ $mission->reference }}"
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
                                                        <input type="number" name="deposit"
                                                            value="{{ $mission->deposit }}"
                                                            class="input-group form-control" placeholder="Montant du dépot"
                                                            required>
                                                    </div>
                                                    <div class="mt-3 col-md-6 input-group input-group-ml">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text text-danger"><i
                                                                    class="far fa-registered"></i></span>
                                                        </div>
                                                        <select name="type" class="custom-select" required>
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
                                                        <label class="form-check-label">
                                                            @if (!empty($mission->ended_at))
                                                                <input type="checkbox" class="form-check-input"
                                                                    name="ended_at" value="0" checked> Mission terminé
                                                            @else
                                                                <input type="checkbox" class="form-check-input"
                                                                    name="ended_at" value="0"> Mission terminé
                                                            @endif
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
                                                    @php $modified = str_replace('-', '', $mission->id); @endphp
                                                    <script>
                                                        function tabFonction{{ $modified }}() {
                                                            const table = document.getElementById("MissionTab{{ str_replace('-', '', $mission->id) }}");
                                                            const row = table.insertRow(1);
                                                            const cell1 = row.insertCell(0);
                                                            const cell2 = row.insertCell(1);
                                                            const cell3 = row.insertCell(2);
                                                            const cell4 = row.insertCell(3);
                                                            const cell5 = row.insertCell(4);
                                                            cell1.innerHTML = '<input type="text" placeholder="Titre tâche" class="btn" name="title_missionline_A' + table
                                                                .rows.length + '" id="title_missionline_A' + table.rows.length + '">'
                                                            cell2.innerHTML = '<input type="text" placeholder="Quantité tâche" class="btn" name = "quantity_missionline_A' +
                                                                table.rows.length + '" id="quantity_missionline_A' + table.rows.length +
                                                                '" onchange="calculate(
                                                            total_missionline_A ' + table.rows.length +',
                                                                quantity_missionline_A ' + table.rows.length + ',
                                                                price_missionline_A ' + table.rows.length + ')
                                                        ">'
                                                        cell3.innerHTML = '<input type="text" placeholder="Prix tâche" class="btn" name="price_missionline_A' + table
                                                            .rows.length + '" id="price_missionline_A' + table.rows.length +
                                                            '" onchange="calculate(
                                                        total_missionline_A ' + table.rows.length +',
                                                            quantity_missionline_A ' + table.rows.length + ',
                                                            price_missionline_A ' + table.rows.length + ')
                                                        ">'
                                                        cell4.innerHTML = '<input type="text" placeholder="Unité tâche" class="btn" name="unity_missionline_A' + table
                                                            .rows.length + '" id="unity_missionline_A' + table.rows.length + '">'
                                                        cell5.innerHTML = '<span id="total_missionline_A' + table.rows.length +
                                                            '" aria-disabled="true" id="total_missionline_A ' + table.rows.length + '"> 0.00 < /span>'
                                                        }
                                                    </script>
                                                    <div class="mt-3 col-md-6 input-group input-group-ml">
                                                        <p onclick="tabFonction{{ $modified }}()">
                                                            Ajouter une nouvelle
                                                            ligne <span id="add_new_line"><i
                                                                    class="far fa-plus-square"></i></span>
                                                        </p>
                                                    </div>
                                                    <div class="mt-3 col-md-12">
                                                        <table class="table table-hover table-striped mb-5 text-center mt-2"
                                                            id="MissionTab{{ str_replace('-', '', $mission->id) }}">
                                                            <thead class="thead-light">
                                                                <tr>
                                                                    <th>Titre</th>
                                                                    <th>Quantité</th>
                                                                    <th>Prix</th>
                                                                    <th>Unité</th>
                                                                    <th>Total</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr class="table-light">
                                                                    <td><input type="text" class="btn"
                                                                            name="title_missionline_A0"
                                                                            id="title_missionline_A0"
                                                                            placeholder="Titre tâche"></td>
                                                                    <td><input type="text" class="btn"
                                                                            name="quantity_missionline_A0"
                                                                            id="quantity_missionline_A0"
                                                                            placeholder="Quantité tâche"
                                                                            onchange="calculate('total_missionline_A0','quantity_missionline_A0','price_missionline_A0')"
                                                                            </td>
                                                                    <td><input type=" text" class="btn"
                                                                            name="price_missionline_A0"
                                                                            id="price_missionline_A0"
                                                                            placeholder="Prix tâche"
                                                                            onchange="calculate('total_missionline_A0','quantity_missionline_A0','price_missionline_A0')"
                                                                            </td>
                                                                    <td><input type="text" class="btn"
                                                                            name="unity_missionline_A0"
                                                                            id="unity_missionline_A0"
                                                                            placeholder="Unité tâche"></td>
                                                                    <td><span id="total_missionline_A0"
                                                                            aria-disabled="true">0.00</span></td>
                                                                </tr>
                                                                @foreach ($missionLines as $missionLine)
                                                                    @if ($missionLine->mission_id === $mission->id)
                                                                        <tr>
                                                                            <td><input type="text" class="btn"
                                                                                    name="title_missionline_{{ $missionLine->id }}"
                                                                                    id="title_missionline_{{ $missionLine->id }}"
                                                                                    value="{{ $missionLine->title }}">
                                                                            </td>
                                                                            <td><input type="text" class="btn"
                                                                                    name="quantity_missionline_{{ $missionLine->id }}"
                                                                                    id="quantity_missionline_{{ $missionLine->id }}"
                                                                                    value="{{ $missionLine->quantity }}"
                                                                                    onchange="calculate('total_missionline_{{ $missionLine->id }}','quantity_missionline_{{ $missionLine->id }}','price_missionline_{{ $missionLine->id }}')"
                                                                                    </td>
                                                                            <td><input type="text" class="btn"
                                                                                    name="price_missionline_{{ $missionLine->id }}"
                                                                                    id="price_missionline_{{ $missionLine->id }}"
                                                                                    value="{{ $missionLine->price }}"
                                                                                    onchange="calculate('total_missionline_{{ $missionLine->id }}','quantity_missionline_{{ $missionLine->id }}','price_missionline_{{ $missionLine->id }}')"
                                                                                    </td>
                                                                            <td><input type="text" class="btn"
                                                                                    name="unity_missionline_{{ $missionLine->id }}"
                                                                                    id="unity_missionline_{{ $missionLine->id }}"
                                                                                    value="{{ $missionLine->unity }}">
                                                                            </td>
                                                                            <td><span
                                                                                    id="total_missionline_{{ $missionLine->id }}"
                                                                                    aria-disabled="true"></span></td>
                                                                        </tr>
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
        </div>
    </div>

    <div class="modal" id="NewModalMission">
        <div class="modal-dialog modal-xl modal-dialog-centered">
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
                                <span class="input-group-text text-danger"><i class="fas fa-euro-sign"></i></span>
                            </div>
                            <input type="number" name="deposit" value="{{ old('deposit') }}"
                                class="input-group form-control" placeholder="Montant du dépot" required>
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
