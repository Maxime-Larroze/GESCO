@extends('auth.template')
@section('auth.transaction.interface.show')
    <div class="row mt-2">
        <div class="col-lg-12 text-center">
            <h3 class="text-center">Liste des transactions</h3>
            <hr>
            <a data-toggle="modal" data-target="#NewModalTransaction"><button class="btn btn-success"><i
                        class="far fa-plus-square"></i> Créer une nouvelle transaction</button></a>
            <table class="table table-responsive-sm table-responsive-md table-responsive-lg table-responsive-xl table-hover table-striped mb-5 text-center mt-2" id="transaction_Table">
                <thead class="thead-light">
                    <tr>
                        <th><span onclick="sortTable('transaction_Table', 0)">ID</span></th>
                        <th><span onclick="sortTable('transaction_Table', 1)">Type</span></th>
                        <th><span onclick="sortTable('transaction_Table', 2)">Source</span></th>
                        <th><span onclick="sortTable('transaction_Table', 3)">Montant (€)</span></th>
                        <th><span onclick="sortTable('transaction_Table', 4)">Payée</span></th>
                        <th>Options</th>
                    </tr>
                </thead>
                @if($transactions->isEmpty())
                </tbody>
            </table>
            <h3 class="text-center">Aucune transaction enregistrée</h3>
                @else
                <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <td>{{$transaction->id}}</td>
                            <td>{{$transaction->source_type}}</td>
                            <td>
                                @php $tmp = 0; @endphp
                                @foreach($missions as $mission)
                                    @if($mission->id === $transaction->source_id)    
                                        {{$mission->title}}
                                        @php $tmp++; @endphp
                                    @endif
                                @endforeach
                                @if($tmp === 0)
                                    @foreach($contributions as $contribution)
                                        @if($contribution->id === $transaction->source_id)    
                                            {{$contribution->title}}
                                            @php $tmp++; @endphp
                                        @endif
                                    @endforeach
                                @endif
                            </td>
                            <td>{{$transaction->price}}</td>
                            <td>
                                @if(!empty($transaction->payed_at))
                                    <span class="text-success font-weight-bold">{{Carbon\Carbon::parse($transaction->payed_at)->format('d/m/Y')}}</span>
                                @else
                                    <span class="text-danger font-weight-bold">Non payé</span>
                                @endif
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6 text-center">
                                        <a href="" data-toggle="modal" data-target="#updateModalTransaction{{$transaction->id}}"><button class="btn btn-warning"><i class="fas fa-edit" aria-hidden="true"></i></button></a>
                                    </div>
                                    <div class="col-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6 text-center">
                                        <form action="" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="transaction_id" value="{{$transaction->id}}">
                                            <button class="btn btn-danger" type="submit"><i class="far fa-trash-alt" aria-hidden="true"></i></button>
                                        </form>
                                    </div>
                                </div>
                                <div class="modal" id="updateModalTransaction{{$transaction->id}}">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form action="{{ route('transactions.update') }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="transaction_id" value="{{$transaction->id}}">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Modification d'une transaction</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body row">
                                                    <div class="mt-3 col-md-6 input-group form-group input-group-ml">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text text-danger"><i class="fas fa-heading"></i></span>
                                                        </div>
                                                        <select name="source_type" class="custom-select" required>
                                                            <option onclick="selectSourceType('missions', true)" value="missions" @if($transaction->source_type === 'missions') selected @endif>Missions</option>
                                                            <option onclick="selectSourceType('contributions', true)" value="contributions" @if($transaction->source_type === 'contributions') selected @endif>Contributions</option>
                                                        </select>
                                                    </div>
                            
                                                    <div class="mt-3 col-md-6 input-group form-group input-group-ml" id="source_id_missions_update">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text text-danger"><i class="fas fa-tasks"></i></span>
                                                        </div>
                                                        <select name="source_id" class="custom-select">
                                                            @foreach ($missions as $mission)
                                                                <option value="{{ $mission->id }}" @if($transaction->source_id === $mission->id) selected @endif>{{ $mission->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mt-3 col-md-6 input-group form-group input-group-ml" id="source_id_contributions_update">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text text-danger"><i class="fas fa-donate"></i></span>
                                                        </div>
                                                        <select name="source_id" class="custom-select">
                                                            @foreach ($contributions as $contribution)
                                                                <option value="{{ $contribution->id }}" @if($transaction->source_id === $contribution->id) selected @endif>{{ $contribution->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                            
                                                    <div class="mt-3 col-md-6 input-group form-group input-group-ml" id="cache_date_update">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text text-danger"><i class="fas fa-euro-sign"></i></span>
                                                        </div>
                                                        <input type="number" class="input-group form-control" name="price" value="{{$transaction->price}}" required>
                                                    </div>
                                                    <div class="mt-3 col-md-6 input-group form-group input-group-ml" id="cache_payed_update">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text text-danger"><i class="far fa-calendar-plus"></i></span>
                                                        </div>
                                                        <input type="date" class="input-group form-control" name="payed_at" value="{{Carbon\Carbon::parse($transaction->payed_at)->format('Y-m-d')}}">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success" id="btn_validate_update"><i class="fas fa-check"></i> Valider</button>
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

    <div class="modal" id="NewModalTransaction">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('transactions.create') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Création d'une transaction</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body row">
                        <div class="mt-3 col-md-6 input-group form-group input-group-ml">
                            <div class="input-group-prepend">
                                <span class="input-group-text text-danger"><i class="fas fa-heading"></i></span>
                            </div>
                            <select name="source_type" class="custom-select" required>
                                <option onclick="selectSourceType('missions', false)" value="missions">Missions</option>
                                <option onclick="selectSourceType('contributions', false)" value="contributions">Contributions</option>
                            </select>
                        </div>

                        <div class="mt-3 col-md-6 input-group form-group input-group-ml" id="source_id_missions">
                            <div class="input-group-prepend">
                                <span class="input-group-text text-danger"><i class="fas fa-tasks"></i></span>
                            </div>
                            <select name="source_id" class="custom-select">
                                @foreach ($missions as $mission)
                                    <option value="{{ $mission->id }}">{{ $mission->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-3 col-md-6 input-group form-group input-group-ml" id="source_id_contributions">
                            <div class="input-group-prepend">
                                <span class="input-group-text text-danger"><i class="fas fa-donate"></i></span>
                            </div>
                            <select name="source_id" class="custom-select">
                                @foreach ($contributions as $contribution)
                                    <option value="{{ $contribution->id }}">{{ $contribution->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-3 col-md-6 input-group form-group input-group-ml" id="cache_date">
                            <div class="input-group-prepend">
                                <span class="input-group-text text-danger"><i class="fas fa-euro-sign"></i></span>
                            </div>
                            <input type="number" class="input-group form-control" placeholder="Montant de la transaction" name="price" value="{{old('price')}}" required>
                        </div>
                        <div class="mt-3 col-md-6 input-group form-group input-group-ml" id="cache_payed">
                            <div class="input-group-prepend">
                                <span class="input-group-text text-danger"><i class="far fa-calendar-plus"></i></span>
                            </div>
                            <input type="date" class="input-group form-control" value="{{old('payed_at')}}" name="payed_at">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="btn_validate"><i class="fas fa-check"></i> Valider</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.getElementById("source_id_contributions").hidden = true;
        document.getElementById("source_id_missions").hidden = true;
        document.getElementById("cache_date").hidden = true;
        document.getElementById("cache_payed").hidden = true;
        document.getElementById("btn_validate").hidden = true;

        document.getElementById("source_id_contributions_update").hidden = true;
        document.getElementById("source_id_missions_update").hidden = true;
        document.getElementById("cache_date_update").hidden = true;
        document.getElementById("cache_payed_update").hidden = true;
        document.getElementById("btn_validate_update").hidden = true;
        function selectSourceType(choice, updated)
        {
            if(updated === false)
            {
                if(choice === 'missions')
                {
                    document.getElementById("source_id_contributions").hidden = true;
                    document.getElementById("source_id_missions").hidden = false;
                    document.getElementById("cache_date").hidden = false;
                    document.getElementById("cache_payed").hidden = false;
                    document.getElementById("btn_validate").hidden = false;
                }
                else if(choice === 'contributions')
                {
                    document.getElementById("source_id_missions").hidden = true;
                    document.getElementById("source_id_contributions").hidden = false;
                    document.getElementById("cache_date").hidden = false;
                    document.getElementById("cache_payed").hidden = false;
                    document.getElementById("btn_validate").hidden = false;
                }
            }
            else if(updated === true)
            {
                if(choice === 'missions')
                {
                    document.getElementById("source_id_contributions_update").hidden = true;
                    document.getElementById("source_id_missions_update").hidden = false;
                    document.getElementById("cache_date_update").hidden = false;
                    document.getElementById("cache_payed_update").hidden = false;
                    document.getElementById("btn_validate_update").hidden = false;
                }
                else if(choice === 'contributions')
                {
                    document.getElementById("source_id_missions_update").hidden = true;
                    document.getElementById("source_id_contributions_update").hidden = false;
                    document.getElementById("cache_date_update").hidden = false;
                    document.getElementById("cache_payed_update").hidden = false;
                    document.getElementById("btn_validate_update").hidden = false;
                }
            }
        }
    </script>
@endsection