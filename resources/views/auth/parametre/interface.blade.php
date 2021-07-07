@extends('auth.template')
@section('auth.parametre.interface.show')
    <h3 class="text-center">Paramètre de l'application</h3>
    <hr>
    <form action="{{route('parametres.store')}}" method="post" class="mb-5">
        @csrf
        @if(!empty($parametre))
        <input type="hidden" name="parametre_id" value="{{$parametre->id}}">
        @method('PUT')
        @endif
        <div class="row">
            <div class="mt-3 col-lg-6 input-group input-group-ml">
                <div class="input-group-prepend">
                    <span class="input-group-text text-primary"><i class="fas fa-signature"></i></span>
                </div>
                <input type="text" name="societe_name" placeholder="Nom de la société" @if(!empty($parametre->societe_name)) value="{{Crypt::decryptString($parametre->societe_name)}}" @endif class="@error('societe_name') is-invalid @enderror input-group form-control" required>
                @error('societe_name')
                    <div class="alert alert-danger alert-dismissible fade show">{{ $message }}</div>
                @enderror
            </div>
            <div class="mt-3 col-lg-6 input-group input-group-ml">
                <div class="input-group-prepend">
                    <span class="input-group-text text-primary"><i class="fas fa-map-marked-alt"></i></span>
                </div>
                <input type="text" name="adresse" placeholder="Adresse de la societe" @if(!empty($parametre->adresse)) value="{{Crypt::decryptString($parametre->adresse)}}" @endif class="@error('adresse') is-invalid @enderror input-group form-control" required>
                @error('adresse')
                    <div class="alert alert-danger alert-dismissible fade show">{{ $message }}</div>
                @enderror
            </div>
            <div class="mt-3 col-lg-6 input-group input-group-ml">
                <div class="input-group-prepend">
                    <span class="input-group-text text-primary"><i class="fas fa-star-of-life"></i></span>
                </div>
                <input type="text" name="siret" placeholder="SIRET de la société" @if(!empty($parametre->siret)) value="{{Crypt::decryptString($parametre->siret)}}" @endif class="@error('siret') is-invalid @enderror input-group form-control" required>
                @error('siret')
                    <div class="alert alert-danger alert-dismissible fade show">{{ $message }}</div>
                @enderror
            </div>
            <div class="mt-3 col-lg-6 input-group input-group-ml">
                <div class="input-group-prepend">
                    <span class="input-group-text text-primary"><i class="fas fa-ticket-alt"></i></span>
                </div>
                <input type="text" name="ape" placeholder="APE de la société" @if(!empty($parametre->ape)) value="{{Crypt::decryptString($parametre->ape)}}" @endif class="@error('ape') is-invalid @enderror input-group form-control" required>
                @error('ape')
                    <div class="alert alert-danger alert-dismissible fade show">{{ $message }}</div>
                @enderror
            </div>
            <div class="mt-3 col-lg-12"><hr></div>
            <div class="mt-3 col-lg-6 input-group input-group-ml">
                <div class="input-group-prepend">
                    <span class="input-group-text text-primary"><i class="fas fa-university"></i></span>
                </div>
                <input type="text" name="rib" placeholder="RIB de la société" @if(!empty($parametre->rib)) value="{{Crypt::decryptString($parametre->rib)}}" @endif class="@error('rib') is-invalid @enderror input-group form-control" required>
                @error('rib')
                    <div class="alert alert-danger alert-dismissible fade show">{{ $message }}</div>
                @enderror
            </div>
            <div class="mt-3 col-lg-6 input-group input-group-ml">
                <div class="input-group-prepend">
                    <span class="input-group-text text-primary"><i class="fas fa-money-check-alt"></i></span>
                </div>
                <input type="text" name="iban" placeholder="IBAN de la société" @if(!empty($parametre->iban)) value="{{Crypt::decryptString($parametre->iban)}}" @endif class="@error('iban') is-invalid @enderror input-group form-control" required>
                @error('iban')
                    <div class="alert alert-danger alert-dismissible fade show">{{ $message }}</div>
                @enderror
            </div>
            <div class="mt-3 col-lg-6 input-group input-group-ml">
                <div class="input-group-prepend">
                    <span class="input-group-text text-primary"><i class="fas fa-money-check"></i></span>
                </div>
                <input type="text" name="bic" placeholder="BIC de la société" @if(!empty($parametre->bic)) value="{{Crypt::decryptString($parametre->bic)}}" @endif class="@error('bic') is-invalid @enderror input-group form-control" required>
                @error('bic')
                    <div class="alert alert-danger alert-dismissible fade show">{{ $message }}</div>
                @enderror
            </div>
            <div class="mt-3 col-lg-6 input-group input-group-ml">
                <div class="input-group-prepend">
                    <span class="input-group-text text-primary"><i class="fas fa-map-marker-alt"></i></span>
                </div>
                <input type="text" name="domiciliation" placeholder="Domiciliation de la société" @if(!empty($parametre->domiciliation)) value="{{Crypt::decryptString($parametre->domiciliation)}}" @endif class="@error('domiciliation') is-invalid @enderror input-group form-control" required>
                @error('domiciliation')
                    <div class="alert alert-danger alert-dismissible fade show">{{ $message }}</div>
                @enderror
            </div>
            <div class="mt-3 col-lg-12"><hr></div>
            <div class="mt-3 col-lg-6 input-group input-group-ml">
                <div class="input-group-prepend">
                    <span class="input-group-text text-primary"><i class="fas fa-percent"></i></span>
                </div>
                <input type="text" name="taux_accompte" placeholder="Taux des accomptes" @if(!empty($parametre->taux_accompte)) value="{{Crypt::decryptString($parametre->taux_accompte) ?? 45}}" @endif class="@error('taux_accompte') is-invalid @enderror input-group form-control" required>
                @error('taux_accompte')
                    <div class="alert alert-danger alert-dismissible fade show">{{ $message }}</div>
                @enderror
            </div>
            <div class="mt-3 col-lg-12"><hr></div>
            <div class="mt-3 col-lg-6 input-group input-group-ml">
                <div class="input-group-prepend">
                    <span class="input-group-text text-primary"><i class="fas fa-file-alt"></i></span>
                </div>
                <textarea name="mention_a" class="@error('mention_a') is-invalid @enderror input-group form-control" placeholder="Mention de la franchise" required cols="30" rows="100">
                    @if(!empty($parametre->mention_a)) {{Crypt::decryptString($parametre->mention_a)}} @endif
                </textarea>
                @error('mention_a')
                    <div class="alert alert-danger alert-dismissible fade show">{{ $message }}</div>
                @enderror
            </div>
            <div class="mt-3 col-lg-6 input-group input-group-ml">
                <div class="input-group-prepend">
                    <span class="input-group-text text-primary"><i class="far fa-file-alt"></i></span>
                </div>
                <textarea name="mention_b" class="@error('mention_b') is-invalid @enderror input-group form-control" placeholder="Modalité des retards de paiement" required cols="30" rows="100">
                    @if(!empty($parametre->mention_b)) {{Crypt::decryptString($parametre->mention_b)}} @endif
                </textarea>
                @error('mention_b')
                    <div class="alert alert-danger alert-dismissible fade show">{{ $message }}</div>
                @enderror
            </div>
            <div class="mt-3 col-lg-12 text-center mb-5">
                <button class="btn btn-success text-center" type="submit">Enregistrer les paramètres</button>
            </div>
        </div>
    </form>
@endsection