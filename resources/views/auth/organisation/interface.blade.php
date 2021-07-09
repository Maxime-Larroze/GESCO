@extends('auth.template')
@section('auth.organisation.interface.show')
    <div class="row mt-2">
        <div class="col-lg-12 text-center">
            <h3 class="text-center">Liste des entreprises</h3>
            <hr>
            <a data-toggle="modal" data-target="#NewModalOrganisation"><button class="btn btn-success"><i
                        class="far fa-plus-square"></i> Créer une organisation</button></a>
            <table class="table table-responsive-sm table-responsive-md table-responsive-lg table-responsive-xl table-hover table-striped mb-5 text-center mt-2" id="organisation_table">
                <thead class="thead-light">
                    <tr>
                        <th onclick="sortTable('organisation_table', 0)">Nom</th>
                        <th onclick="sortTable('organisation_table', 1)">Adresse email</th>
                        <th onclick="sortTable('organisation_table', 2)">Téléphone</th>
                        <th onclick="sortTable('organisation_table', 3)">Type</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @if($organisations->isEmpty())
                        </tbody>
                    </table>
                    <h3 class="text-center">Aucun client enregistré</h3>
                @else
                    @foreach ($organisations as $organisation)
                        <tr>
                            <td>{{ $organisation->name }}</td>
                            <td><a href="mailto:{{ $organisation->email }}">{{ $organisation->email }}</a></td>
                            <td><a href="tel:+{{ $organisation->tel }}">{{ $organisation->tel }}</a></td>
                            <td>{{ $organisation->type }}</td> 
                            <td>
                                <button class="btn btn-warning form-check-inline" type="button" data-toggle="modal"
                                    data-target="#ModalOrganisation{{ $organisation->id }}"><i class="fas fa-edit"></i></button>
                                <form class="form-check-inline" action="{{ route('organisations.destroy') }}" method="POST">
                                    @csrf @method('DELETE') <input type="hidden" name="organisation_id"
                                        value="{{ $organisation->id }}"> <button class="btn btn-danger" type="submit"><i
                                            class="far fa-trash-alt"></i></button></form>
                            </td>
                        </tr>
                        <div class="modal" id="ModalOrganisation{{ $organisation->id }}">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="{{ route('organisations.update') }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="organisation_id" value="{{ $organisation->id }}">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Modification de l'organisation
                                                [{{ $organisation->name }}]</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body row">
                                            <div class="mt-3 col-md-12 input-group input-group-ml">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text text-danger">N</span>
                                                </div>
                                                <input type="text" name="name" value="{{ $organisation->name }}"
                                                    class="input-group form-control" placeholder="Nom de l'organisation"
                                                    required>
                                            </div>
                                            <div class="mt-3 col-md-6 input-group input-group-ml">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text text-danger"><i
                                                            class="fas fa-at"></i></span>
                                                </div>
                                                <input type="email" name="email" value="{{ $organisation->email }}"
                                                    class="input-group form-control"
                                                    placeholder="Adresse email de l'organisation" required>
                                            </div>
                                            <div class="mt-3 col-md-6 input-group input-group-ml">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text text-danger"><i
                                                            class="fas fa-phone-alt"></i></span>
                                                </div>
                                                <input type="tel" name="tel" value="{{ $organisation->tel }}"
                                                    class="input-group form-control"
                                                    placeholder="Numéro de téléphone de l'organisation" required>
                                            </div>
                                            <div class="mt-3 col-md-6 input-group input-group-ml">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text text-danger"><i
                                                            class="fas fa-map-marker-alt"></i></span>
                                                </div>
                                                <input type="text" name="address" value="{{ $organisation->address }}"
                                                    class="input-group form-control"
                                                    placeholder="Adresse postale de l'organisation" required>
                                            </div>
                                            <div class="mt-3 col-md-6 input-group input-group-ml">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text text-danger"><i
                                                            class="fab fa-ideal"></i></span>
                                                </div>
                                                <input type="text" value="{{ $organisation->slug }}"
                                                    class="input-group form-control" disabled>
                                            </div>
                                            <div class="mt-3 col-md-6 input-group input-group-ml">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text text-danger"><i
                                                            class="far fa-registered"></i></span>
                                                </div>
                                                <select name="type" class="custom-select" required>
                                                    @if ($organisation->type === 'organisation')
                                                        <option value="organisation" selected>organisation</option>
                                                        <option value="school">school</option>
                                                        <option value="government">government</option>
                                                    @elseif($organisation->type === "school")
                                                        <option value="organisation">organisation</option>
                                                        <option value="school" selected>school</option>
                                                        <option value="government">government</option>
                                                    @elseif($organisation->type === "government")
                                                        <option value="organisation">organisation</option>
                                                        <option value="school">school</option>
                                                        <option value="government" selected>government</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i>
                                                Valider</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>

    <div class="modal" id="NewModalOrganisation">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('organisations.create') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Création d'une organisation</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body row">
                        <div class="mt-3 col-md-12 input-group input-group-ml">
                            <div class="input-group-prepend">
                                <span class="input-group-text text-danger">N</span>
                            </div>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Nom de l'organisation"
                                class="input-group form-control" required>
                        </div>
                        <div class="mt-3 col-md-6 input-group input-group-ml">
                            <div class="input-group-prepend">
                                <span class="input-group-text text-danger"><i class="fas fa-at"></i></span>
                            </div>
                            <input type="email" name="email" value="{{ old('email') }}"
                                placeholder="Adresse email de l'organisation" class="input-group form-control" required>
                        </div>
                        <div class="mt-3 col-md-6 input-group input-group-ml">
                            <div class="input-group-prepend">
                                <span class="input-group-text text-danger"><i class="fas fa-phone-alt"></i></span>
                            </div>
                            <input type="tel" name="tel" value="{{ old('tel') }}"
                                placeholder="Numéro de téléphone de l'organisation" class="input-group form-control"
                                required>
                        </div>
                        <div class="mt-3 col-md-6 input-group input-group-ml">
                            <div class="input-group-prepend">
                                <span class="input-group-text text-danger"><i class="fas fa-map-marker-alt"></i></span>
                            </div>
                            <input type="text" name="address" value="{{ old('address') }}"
                                placeholder="Adresse postale de l'organisation" class="input-group form-control" required>
                        </div>
                        <div class="mt-3 col-md-6 input-group input-group-ml">
                            <div class="input-group-prepend">
                                <span class="input-group-text text-danger"><i class="far fa-registered"></i></span>
                            </div>
                            <select name="type" class="custom-select" required>
                                <option value="organisation">organisation</option>
                                <option value="school">school</option>
                                <option value="government">government</option>
                            </select>
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