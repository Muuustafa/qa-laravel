<template>
  <div class="row my-3">
    <div class="col-md-12">
      <div class="card shadow">
        <div class="card-header bg-danger justify-content-between align-items-center">
          <h3 class="text-light"> Commentaires </h3>
        </div>
        <div class="card-body">
          <div v-if="user_id && verified_user">
            <div class="form-group mb-3">
              <textarea v-model="body" class="form-control" cols="30" rows="2" placeholder="Tapez ici..."></textarea>
            </div>
            <div class="form-group mb-3">
              <button class="btn btn-sm btn-success" v-show="body.length" @click="addComment">
                {{ disableValidationButtons ? 'Commentaire validé' : 'Envoyer' }}
              </button>
            </div>
          </div>
          <div v-else>
            <a href="/login" :href="to" class="btn btn-link">
              Connectez-vous pour commenter / Vérifiez votre compte.
            </a>
          </div>
          <ul class="list-group" v-if="comments.length">
            <li class="list-group-item d-flex flex-column" v-for="(comment, index) in comments" :key="index">
              <span><b>{{ comment.user.name }}:</b> <i>{{ comment.body }}</i></span>
              <span>{{ comment.created_at }}</span>
              <div v-if="validation" id="app">
                <span>
                  <button v-if="!comment.validated && !disableValidationButtons"
                          v-on:click="validateComment(comment)"
                          class="btn btn-sm btn-success">
                    Valider
                  </button>
                  <i v-else-if="comment.validated" class="fas fa-check-circle text-success"></i>
                </span>
              </div>
            </li>
          </ul>
          <div class="alert alert-dark" v-else>
            Aucun commentaire pour l'instant!
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// Import d'Axios pour les appels API
import axios from 'axios';

export default {
  name: 'CommentComponent',
  props: ['question_id', 'user_id', 'verified_user', 'validation'],
  data() {
    return {
      body: '',
      comments: [],
      to: !this.user_id && !this.verified_user ? '/login' : '/email/verify',
      disableValidationButtons: false,
    };
  },
  mounted() {
    this.getComments();
  },
  methods: {
    showAlert() {
      Swal.fire('Vous avez validé ce commentaire!', '', 'success');
    },
    addComment() {
      const comment = { body: this.body, question_id: this.question_id, user_id: this.user_id };
      axios.post(`/api/comments/add`, comment)
        .then((res) => {
          if (res.data.succès) {
            this.body = '';
            this.getComments();
          }
        })
        .catch((err) => console.log(err));
    },
    getComments() {
      axios.get(`/api/question/${this.question_id}/comments`)
        .then((res) => {
          this.comments = res.data.map(comment => ({
            ...comment,
            validated: false,
          }));
        })
        .catch((err) => console.log(err));
    },
    validateComment(comment) {
      // Exemple de logique de validation : valider si la longueur du commentaire est supérieure à 10 caractères
      if (comment.body.length > 10) {
        comment.validated = true;
        this.disableValidationButtons = true;
        Swal.fire('Commentaire validé!', '', 'success');
      } else {
        Swal.fire('Le commentaire doit contenir au moins 10 caractères.', '', 'error');
      }
    },
  },
};
</script>
