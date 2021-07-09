@extends('auth.template')
@section('auth.contribution.interface.show')
    <div class="row mt-2">
        <div class="col-lg-12 text-center">
            <h3 class="text-center">Liste des contributions</h3>
            <hr>
            <a data-toggle="modal" data-target="#NewModalContribution"><button class="btn btn-success"><i
                        class="far fa-plus-square"></i> Créer une nouvelle contribution</button></a>
            <table class="table table-responsive-sm table-responsive-md table-responsive-lg table-responsive-xl table-hover table-striped mb-5 text-center mt-2" id="contribution_Table">
                <thead class="thead-light">
                    <tr>
                        <th><span onclick="sortTable('contribution_Table', 0)">ID</span></th>
                        <th><span onclick="sortTable('contribution_Table', 1)">Montant (€)</span></th>
                        <th><span onclick="sortTable('contribution_Table', 2)">Titre</span></th>
                        <th><span onclick="sortTable('contribution_Table', 3)">Organisation</span></th>
                        <th>Options</th>
                    </tr>
                </thead>
                @if($contributions->isEmpty())
                </tbody>
            </table>
            <h3 class="text-center">Aucune contribution enregistrée</h3>
                @else
                <tbody>
                    @foreach ($contributions as $contribution)
                        <tr>
                            <td>{{$contribution->id}}</td>
                            <td>{{$contribution->price}}</td>
                            <td>{{$contribution->title}}</td>
                            <td>
                                @foreach($organisations as $organisation)
                                    @if($organisation->id === $contribution->organisation_id)    
                                        {{$organisation->name}}
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6 text-center">
                                        <a href="" data-toggle="modal" data-target="#updateModalTransaction{{$contribution->id}}"><button class="btn btn-warning"><i class="fas fa-edit" aria-hidden="true"></i></button></a>
                                    </div>
                                    <div class="col-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6 text-center">
                                        <form action="" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="contribution_id" value="{{$contribution->id}}">
                                            <button class="btn btn-danger" type="submit"><i class="far fa-trash-alt" aria-hidden="true"></i></button>
                                        </form>
                                    </div>
                                </div>

                                <div class="modal" id="updateModalTransaction{{$contribution->id}}">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form action="{{ route('contributions.update') }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="contribution_id" value="{{$contribution->id}}">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Modification d'une contribution</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="mt-3 col-md-12 input-group input-group-ml">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text text-danger"><i class="fas fa-heading"></i></span>
                                                    </div>
                                                    <input type="text" name="title" value="{{ $contribution->title }}" class="input-group form-control"
                                                        placeholder="Titre de la contribution" required>
                                                </div>
                                                <div class="mt-3 col-md-12 input-group input-group-ml">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text text-danger"><i class="far fa-registered"></i></span>
                                                    </div>
                                                    <select name="organisation_id" class="custom-select" required>
                                                        @foreach ($organisations as $organisation)
                                                            <option value="{{ $organisation->id }}" @if($organisation->id === $contribution->organisation_id) selected @endif>{{ $organisation->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mt-3 col-md-12 form-group input-group input-group-ml">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text text-danger"><i class="fas fa-comment-medical"></i></span>
                                                    </div>
                                                    <textarea class="form-control" rows="5" placeholder="Commentaire sur la contribution"
                                                        name="comment">{{ $contribution->comment }}</textarea>
                                                </div>
                                                <div class="mt-3 col-md-12 input-group form-group input-group-ml" id="cache_date">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text text-danger"><i class="fas fa-euro-sign"></i></span>
                                                    </div>
                                                    <input type="number" class="input-group form-control" name="price" placeholder="Montant de la contribution" value="{{$contribution->price}}" required>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Valider</button>
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

    <div class="modal" id="NewModalContribution">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('contributions.create') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Création d'une contribution</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="mt-3 col-md-12 input-group input-group-ml">
                        <div class="input-group-prepend">
                            <span class="input-group-text text-danger"><i class="fas fa-heading"></i></span>
                        </div>
                        <input type="text" name="title" value="{{ old('title') }}" class="input-group form-control"
                            placeholder="Titre de la contribution" required>
                    </div>
                    <div class="mt-3 col-md-12 input-group input-group-ml">
                        <div class="input-group-prepend">
                            <span class="input-group-text text-danger"><i class="far fa-registered"></i></span>
                        </div>
                        <select name="organisation_id" class="custom-select" required>
                            @foreach ($organisations as $organisation)
                                <option value="{{ $organisation->id }}">{{ $organisation->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mt-3 col-md-12 form-group input-group input-group-ml">
                        <div class="input-group-prepend">
                            <span class="input-group-text text-danger"><i class="fas fa-comment-medical"></i></span>
                        </div>
                        <textarea class="form-control" rows="5" placeholder="Commentaire sur la contribution"
                            name="comment">{{ old('comment') }}</textarea>
                    </div>
                    <div class="mt-3 col-md-12 input-group form-group input-group-ml" id="cache_date">
                        <div class="input-group-prepend">
                            <span class="input-group-text text-danger"><i class="fas fa-euro-sign"></i></span>
                        </div>
                        <input type="number" class="input-group form-control" name="price" placeholder="Montant de la contribution" value="{{old('price')}}" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Valider</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection