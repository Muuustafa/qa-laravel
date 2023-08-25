@extends('layouts.app')

@section('title')
    Mes Questions
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center my-5 ">
            <div class="col-md-10">
                <div class="card shadow">
                    <div class="card-header bg-danger d-flex justify-content-between align-items-center">
                        <h3 class="text-light">{{ __('Mes questions') }}</h3>
                        <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addQuestionModal"><i
                            class="bi-plus-circle me-2"></i>Ajouter une question</button>
                    </div>
                    <div class="card-body" id="show_all_questions" >
                        <table class="table table-hover table-stripped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Titre</th>
                                <th>Tag</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($questions as $key => $question)
                                <tr>
                                    <td>{{$key+=1}}</td>
                                    <td>{{$question->titre}}</td>
                                    <td>
                                          <span class="badge bg-success">
                                              {{$question->collective->titre}}
                                          </span>
                                    </td>
                                    <td class="d-flex justify-content-center align-items-center">
                                        <a href="{{route('questions.show', $question)}}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i>
                                        </a> &ensp;
                                        <a href="#" data-id="{{$question->id}}" 
                                            class="btn btn-sm btn-warning editIcone"  data-bs-toggle="modal" data-bs-target="#editQuestionModal">
                                              <i class="fas fa-edit"></i>
                                          </a>
                                          &ensp;                                  
                                          <a href="#" id="{{$question->id}}" class="btn btn-sm btn-danger deleteIcone">
                                              <i class="fas fa-trash"></i>
                                          </a>
                                          @include('questions.action')
                                           
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-centent-center">
                            {{$questions->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

{{-- add new question modal start --}}
<div class="modal fade" id="addQuestionModal" tabindex="-1" role="dialog" aria-labelledby="AddModalLabel"
    data-bs-backdrop="static" aria-hidden="true" >
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ajout d'une question</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" id="add_question_form" enctype="multipart/form-data">
        @csrf
        <div class="modal-body p-4 bg-light">
          <div class="row">
            <select class="form-select form-select-lg mb-3" name="collective_id" id="collective_id" 
            aria-label="form-select-lg example">
                <option selected>Selectionner une collective</option>
                  @foreach($collectives as $key => $collective)
                      <option value="{{$collective->id}}">
                          {{$collective->titre}}
                      </option>
                   @endforeach
              </select>
              <select class="form-select form-select-lg mb-3" name="category_id" id="category_id" 
              aria-label="form-select-lg example">
                  <option selected>Selectionner une catégorie</option>
                    @foreach($categories as $key => $cat)
                        <option value="{{$cat->id}}">
                            {{$cat->nom}}
                        </option>
                     @endforeach
              </select>
              <div class="col-lg">
                <label for="titre">{{ __('Titre') }} <span class="text-danger fw-bold">*</span></label>
                <input type="text" id="name" name="titre" class="form-control @error('titre') is-invalid @enderror" 
                  placeholder="Entrer titre" value="{{ old('titre') }}" required autocomplete="titre" autofocus>
              </div>
          </div> <br>
          <div class="form-floating">
            <textarea class="form-control" name="body" placeholder="Entrer une description" 
            id="floatingTextarea2" style="height: 100px"></textarea>
            <label for="floatingTextarea2">Description</label>
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
          <button type="submit" id="add_question_btn" class="btn btn-primary">Ajouter</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- add new collective modal end --}}
@endsection

