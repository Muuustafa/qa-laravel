@extends('layouts.app')

@section('title')
    Mes Collectives | Mini slack
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center my-5 ">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-danger d-flex justify-content-between align-items-center">
                    <h3 class="text-light">{{ __('Mes collectives') }}</h3>
                    <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addCollectiveModal"><i
                        class="bi-plus-circle me-2"></i>Ajouter une collective</button>
                  </div>
                <div class="card-body" id="show_all_collectives">
                    <table class="table table-hover table-stripped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Titre</th>
                            <th>Question</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($collectives as $key => $collective)
                            <tr>
                                <td>{{$key+=1}}</td>
                                <td>{{$collective->titre}}</td>
                                <td>
                                      <span class="badge bg-success">
                                          {{$collective->questions->count()}}
                                      </span>
                                </td>
                                <td class="d-flex justify-content-center align-items-center">
                                    <a href="{{route('collectives.show', $collective)}}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i>
                                    </a> &ensp;
                                    <a href="#"  data-id="{{$collective->id}}" class="btn btn-sm btn-warning editIcon" 
                                      data-bs-toggle="modal" data-bs-target="#editCollectiveModal">
                                        <i class="fas fa-edit"></i>
                                    </a> &ensp;                                  
                                    <a href="#" id="{{$collective->id}}" class="btn btn-sm btn-danger deleteIcon">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-centent-center">
                        {{$collectives->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- edit collective modal start --}}
<div class="modal fade" id="editCollectiveModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modification Collective</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="edit_collective_form" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" id="id">
        <div class="modal-body p-4 bg-light">
          <div class="row">
            <select class="form-select form-select-lg mb-3" id="category_id" name="category_id" 
            aria-label=".form-select-lg example">
                <option selected>Selectionner une catégorie</option>
                <option value="1">Informatique</option>
                <option value="2">Gestion</option>
                <option value="3">Finance</option>
                <option value="4">Comptabilité</option>
                <option value="5">Réseau</option>
              </select>
            <div class="col-lg">
              <label for="titre">Titre</label>
              <input type="text" name="titre" id="titre" class="form-control" placeholder="Entrer titre" required>
            </div>
          </div> <br>
          <div class="form-floating">
            <textarea class="form-control description" name="description" placeholder="Entrer une description" 
            id="floatingTextarea2" style="height: 100px"></textarea>
            <label for="floatingTextarea2">Description</label>
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
          <button type="submit" id="edit_collective_btn" class="btn btn-primary">Modifier</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- edit collective modal end --}}


{{-- add new collective modal start --}}
<div class="modal fade" id="addCollectiveModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ajout d'une collective</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="{{ route('collectives.store') }}" id="add_collective_form" enctype="multipart/form-data">
        @csrf
        <div class="modal-body p-4 bg-light">
          <div class="row">
            <select class="form-select form-select-lg mb-3" name="category_id" aria-label=".form-select-lg example">
                <option selected>Selectionner une catégorie</option>
                <option value="1">Informatique</option>
                <option value="2">Gestion</option>
                <option value="3">Finance</option>
                <option value="4">Comptabilité</option>
                <option value="5">Réseau</option>
              </select>
            <div class="col-lg">
              <label for="titre">Titre</label>
              <input type="text" name="titre" class="form-control" placeholder="Entrer titre" required>
            </div>
          </div> <br>
          <div class="form-floating">
            <textarea class="form-control" name="description" placeholder="Entrer une description" 
            id="floatingTextarea2" style="height: 100px"></textarea>
            <label for="floatingTextarea2">Description</label>
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
          <button type="submit" id="add_collective_btn" class="btn btn-primary">Ajouter</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- add new collective modal end --}}


   
   
   
   
























   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   

   
@endsection
