
{{-- edit question modal start --}}
<div class="modal fade" id="editQuestionModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    data-bs-backdrop="static" aria-hidden="true" >
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modification d'une question</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" id="edit_question_form" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" id="id">
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
                <input type="text" id="titre" name="titre" class="form-control" 
                  placeholder="Entrer titre" required>
              </div>
          </div> <br>
          <div class="form-floating">
            <textarea class="form-control" name="body" placeholder="Entrer une description" 
            id="floatingTextarea2" style="height: 100px"></textarea>
            <label for="floatingTextarea2">Description</label>
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
          <button type="submit" id="edit_question_btn" class="btn btn-primary">Modifier</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- add new collective modal end --}}


<script>

    // delete question ajax request
$(document).on('click', '.deleteIcone', function(e) {
     e.preventDefault();
     let id = $(this).attr('id');
     let csrf = '{{ csrf_token() }}';
     Swal.fire({
       title: 'Etes vous sûr(e)?',
       text: "Cette action est irreversible !",
       icon: 'warning',
       showCancelButton: true,
       confirmButtonColor: '#3085d6',
       cancelButtonColor: '#d33',
       confirmButtonText: 'Oui, Supprimer!'
     }).then((result) => {
       if (result.isConfirmed) {
         $.ajax({
           url: '{{ route('delete') }}',
           method: 'delete',
           data: {
             id: id,
             _token: csrf
           },
           success: function(response) {
             console.log(response);
             Swal.fire(
               'Supprimé !',
               'La collective a été supprimée avec succés...',
               'success'
             )
             // Appel initial pour récupérer les collectives
             fetchAllQuestion();
           }
         });
       }
     })
   });

function fetchAllQuestion() {
 $.ajax({
   url: '{{ route('questions.index') }}', // Remplacez par votre route
   method: 'get',
   success: function(response) {
     // Rechargez la page
     location.reload();
   }
 });
}
</script>