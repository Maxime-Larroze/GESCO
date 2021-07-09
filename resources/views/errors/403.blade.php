@extends('errors.template')
@section('errors.403.show')
    <div class="row mt-2">
        <div class="col-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 text-center">
            <h1 class="mt-5">Erreur 403</h1>
            <p>Vous n'avez pas l'autorisation nécéssaire pour accéder à la ressource demandée</p>
            <p>Pour modifier votre accès, merci de contacter votre administrateur d'application</p>
            <p>Vous pouvez <a href="{{route('dashboard')}}">retourner à la page d'accueuil ici</a></p>
        </div>
    </div>
@endsection