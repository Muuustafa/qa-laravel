<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <script src="{{ mix('/js/app.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @yield('styles')
    <title>@yield('titre')</title>
</head>
<body>
    @include('layouts.navbar')
    @yield('content')
    

<!-- Optional JavaScript; choose one of the two! -->


<!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="{{ mix('/js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>-->

<!-- Dans votre fichier index.blade.php ou dans le fichier de mise en page (layout) -->
<!-- Ajoutez les liens vers les fichiers CSS et JavaScript de SweetAlert -->

<script>
$(document).ready(function() {
  // Soumission du formulaire d'ajout de collective
  $("#add_collective_form").submit(function(e) {
    e.preventDefault();
    Swal.fire({
      title: 'Êtes-vous sûr?',
      text: "Voulez-vous vraiment ajouter cette collective?",
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Oui',
      cancelButtonText: 'Annuler'
    }).then((result) => {
      if (result.isConfirmed) {
        const fd = new FormData(this);
        $("#add_collective_btn").text('Ajout en cours...');

        $.ajax({
          url: '{{ route('collectives.store') }}', // Remplacez par le route store
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == 200) {
              Swal.fire(
                'Ajouté!',
                'Collective ajoutée avec succès!',
                'success'
              );
              fetchAllCollectives();
            }
            $("#add_collective_btn").text('Ajouter');
            $("#add_collective_form")[0].reset();
            $("#addCollectiveModal").modal('hide'); //Pour fermer le modal d'ajout
          }
        });
      }
    });
  });


   // delete collective ajax request
   $(document).on('click', '.deleteIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        let csrf = '{{ csrf_token() }}';
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
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
                  'Deleted!',
                  'Your file has been deleted.',
                  'success'
                )
                // Appel initial pour récupérer les collectives
                fetchAllCollectives();
              }
            });
          }
        })
      });

    // Lorsqu'on clique sur le bouton "Modifier"
    $(document).on('click', '.editIcon', function(e) {
      //Fermer le modal d'ajout pour que le modal edit puisse sortir
      //$('#addCollectiveModal').modal('skip');
        e.preventDefault();
        var id = $(this).data('id');
        
        // Remplir les champs du formulaire avec les détails de la collective
        $.get('/collective/' + id, function(data) {
            $('#id').val(data.id);
            $('#titre').val(data.titre);
            $('#floatingTextarea2').val(data.description);
            $('#category_id').val(data.category_id);

        });
    });

    // Lorsqu'on clique sur "Enregistrer les modifications"
    $(document).on('click', '#edit_collective_btn', function(e) {
        e.preventDefault();
        var formData = $('#edit_collective_form').serialize();
        var id = $('#id').val();

        // Validation des champs
        var titre = $('#titre').val();
        var description = $('#description').val();
        var category_id = $('#category_id').val();

        // Envoyer les modifications via Ajax
        $.ajax({
            url: '/collective/' + id,
            type: 'PUT',
            data: formData,
            success: function(data) {
                // Fermer le modal et afficher une alerte de succès
                $('#editCollectiveModal').modal('hide');
                swal.fire("Succès", "Collective modifiée avec succès", "success");
                // Mettre à jour l'affichage de la collective modifiée
                // Peut-être en remplaçant le contenu actuel par le nouveau contenu
                 // Recharger la page
                 fetchAllCollectives();
            },
            error: function() {
                swal.fire("Erreur", "Une erreur est survenue lors de la modification", "error");
            }
        });
    });

   
 function fetchAllCollectives() {
  $.ajax({
    url: '{{ route('collectives.fetchAll') }}', // Remplacez par votre route
    method: 'get',
    success: function(response) {
      // Rechargez la page
      location.reload();
    }
  });
}
});
</script>

</body>
</html>
