@extends('auth.template')
@section('auth.profil.interface.update')
<div class="row">
    <div class="col-lg-2"></div>
    <div class="col-lg-8">
            @csrf
            <div class="row mb-5">
                <div class="col-lg-12 text-center">
                    <img src="{{$user->picture}}" class="img-fluid" width="22%" alt="Image sexe F">
                </div>
                <div class="mt-3 col-lg-12 text-center">
                    <h5>Membre depuis le {{date('d-m-Y à H:i', strtotime($user->created_at))}}</h5>
                </div>
                <div class="mt-3 col-lg-12 text-center input-group input-group-ml">
                    <div class="input-group-prepend">
                        <span class="input-group-text text-danger">Votre identifiant</span>
                    </div>
                    <input type="text" value="{{ $user->email }}" class="input-group form-control text-center" disabled>
                </div>
                <div class="mt-3 col-lg-6 input-group input-group-ml">
                    <div class="input-group-prepend">
                        <span class="input-group-text text-danger">N</span>
                    </div>
                    <input type="text" name="nom" placeholder="Nom" value="{{ $user->lastname }}" class="@error('nom') is-invalid @enderror input-group form-control" disabled>
                    @error('nom')
                        <div class="alert alert-danger alert-dismissible fade show">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mt-3 col-lg-6 input-group input-group-ml">
                    <div class="input-group-prepend">
                        <span class="input-group-text text-danger">P</span>
                    </div>
                    <input type="text" name="prenom" placeholder="Prénom" value="{{ $user->firstname }}" class="@error('prenom') is-invalid @enderror input-group form-control" disabled>
                    @error('prenom')
                        <div class="alert alert-danger alert-dismissible fade show">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mt-3 col-lg-6 input-group input-group-ml">
                    <div class="input-group-prepend">
                        <span class="input-group-text text-danger"><i class="fas fa-at"></i></span>
                    </div>
                    <input type="email" name="email" placeholder="Adresse email" value="{{ $user->email }}" class="@error('email') is-invalid @enderror input-group form-control" disabled>
                    @error('email')
                        <div class="alert alert-danger alert-dismissible fade show">{{ $message }}</div>
                    @enderror
                </div>
            </div>
    </div>
    <div class="col-lg-2"></div>
</div>
@endsection