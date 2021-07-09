@extends('errors.template')
@section('errors.404.show')
    <div class="row mt-2">
        <div class="col-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 text-center">
            <h1 class="mt-5">Erreur 404</h1>
            <p>La page demandé n'héxiste pas ou à été déplacée</p>
            <p>Vous pouvez <a href="{{route('dashboard')}}">retourner à la page d'accueuil ici</a></p>
        </div>
    </div>
@endsection