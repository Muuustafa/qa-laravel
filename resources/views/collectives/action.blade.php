
{{-- edit collective modal start --}}
<div class="modal fade" id="editCollectiveModal" role="dialog" tabindex="-1" aria-labelledby="editModalLabel"
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


