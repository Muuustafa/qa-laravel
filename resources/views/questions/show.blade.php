@extends('layouts.app') <!-- Étendre le layout de l'application -->

@section('titre')
    {{ $questions->titre}} <!-- Insérer le titre de la question dans la section 'titre' -->
@endsection

@section('content')
    <div class="container" id="app">
        <div class="row my-5 ">
            <!-- Inclure le composant de vote avec les propriétés id et votes -->
            <vote-component id="{{$questions->id}}" votes="{{$questions->votes}}"></vote-component>
            
            <div class="col-md-10">
                <div class="card shadow">
                    <div class="card-header bg-danger">
                        <h4 class="text-light">
                            {{$questions->titre}} <!-- Afficher le titre de la question -->
                        </h4>
                    </div>

                    <div class="card-body">
                        <div class="card-text">
                            {{$questions->body}} <!-- Afficher le contenu de la question -->
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-between">
                        <span class="fw-bold">
                             {{$questions->user->name}} <!-- Afficher le nom de l'utilisateur qui a posé la question -->
                        </span>
                        <span class="fw-bold">
                             {{$questions->created_at->diffForHumans()}} <!-- Afficher le temps écoulé depuis la création de la question -->
                        </span>
                    </div>
                </div>
                
                <!-- Inclure le composant de commentaire avec les propriétés question_id, user_id, verified_user et validation -->
                <comment-component
                    question_id="{{$questions->id}}"
                    user_id="{{auth()->check() ? auth()->user()->id: null}}"
                    verified_user="{{auth()->check() && auth()->user()->email_verified_at !==null ? true : false }}"
                    validation="{{auth()->check() && auth()->user()->type == 'superviseur'}}"
                >
                </comment-component>
            </div>
        </div>
    </div>
@endsection
