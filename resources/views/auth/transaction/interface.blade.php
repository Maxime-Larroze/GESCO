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
                        <th><span onclick="sortTable('transaction_Table', 0)">Référence</span></th>
                        <th><span onclick="sortTable('transaction_Table', 1)">Titre</span></th>
                        <th><span onclick="sortTable('transaction_Table', 2)">Organisation</span></th>
                        <th><span onclick="sortTable('transaction_Table', 3)">Terminé</span></th>
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
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
                @endif
        </div>
    </div>

    <div class="modal" id="NewModalTransaction">
        <div class="modal-dialog modal-xl modal-dialog-centered">
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
                                <option onclick="selectSourceType('missions')" value="missions">Missions</option>
                                <option onclick="selectSourceType('contributions')" value="contributions">Contributions</option>
                            </select>
                        </div>

                        <div class="mt-3 col-md-6 input-group form-group input-group-ml" id="source_id_missions">
                            <div class="input-group-prepend">
                                <span class="input-group-text text-danger"><i class="fas fa-tasks"></i></span>
                            </div>
                            <select name="source_id" class="custom-select" required>
                                @foreach ($missions as $mission)
                                    <option value="{{ $mission->id }}">{{ $mission->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-3 col-md-6 input-group form-group input-group-ml" id="source_id_contributions">
                            <div class="input-group-prepend">
                                <span class="input-group-text text-danger"><i class="fas fa-donate"></i></span>
                            </div>
                            <select name="source_id" class="custom-select" required>
                                @foreach ($contributions as $contribution)
                                    <option value="{{ $contribution->id }}">{{ $contribution->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-3 col-md-6 input-group form-group input-group-ml" id="cache_date">
                            <div class="input-group-prepend">
                                <span class="input-group-text text-danger"><i class="fas fa-euro-sign"></i></span>
                            </div>
                            <input type="number" class="input-group form-control" name="price" required>
                        </div>
                        <div class="mt-3 col-md-6 input-group form-group input-group-ml" id="cache_payed">
                            <div class="input-group-prepend">
                                <span class="input-group-text text-danger"><i class="far fa-calendar-plus"></i></span>
                            </div>
                            <input type="date" class="input-group form-control" name="payed_at">
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
        function selectSourceType(choice)
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
    </script>
@endsection