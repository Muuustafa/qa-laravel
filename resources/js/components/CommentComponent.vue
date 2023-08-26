<template>
  <!-- Le template représente la structure visuelle de votre composant -->
  <div class="row my-3">
    <!-- Crée une row pour mettre en forme les éléments suivants -->
    <div class="col-md-12">
      <!-- Utilise une colonne de largeur 12 sur une grille à 12 colonnes pour envelopper le contenu -->
      <div class="card shadow">
        <!-- Crée une carte stylisée avec une ombre -->
        <div class="card-header bg-danger justify-content-between align-items-center">
          <!-- Header de la carte avec un arrière-plan rouge et un alignement des éléments -->
          <h3 class="text-light"> Commentaires </h3>
        </div>
        <div class="card-body">
          <!-- Corps de la carte contenant le contenu principal -->
          <div v-if="user_id && verified_user">
            <!-- Vérifie si l'utilisateur est connecté et vérifié -->
            <div class="form-group mb-3">
              <textarea v-model="body" class="form-control" cols="30" rows="2" placeholder="Tapez ici..."></textarea>
              <!-- Champ de texte où l'utilisateur peut entrer un commentaire -->
            </div>
            <div class="form-group mb-3">
              <button class="btn btn-sm btn-success" v-show="body.length" @click="addComment">
                {{ disableValidationButtons ? 'Commentaire validé' : 'Envoyer' }}
                <!-- Bouton pour ajouter un commentaire, le texte change en fonction de la validation -->
              </button>
            </div>
          </div>
          <div v-else>
            <!-- Si l'utilisateur n'est pas connecté ou vérifié -->
            <a href="/login" :href="to" class="btn btn-link">
              Connectez-vous pour commenter / Vérifiez votre compte.
            </a>
            <!-- Lien pour se connecter ou vérifier le compte -->
          </div>
          <ul class="list-group" v-if="comments.length">
            <!-- Liste des commentaires -->
            <li class="list-group-item d-flex flex-column" v-for="(comment, index) in comments" :key="index">
              <!-- Pour chaque commentaire -->
              <span><b>{{ comment.user.name }}:</b> <i>{{ comment.body }}</i></span>
              <!-- Affiche le nom de l'utilisateur et le contenu du commentaire -->
              <span>{{ comment.created_at }}</span>
              <!-- Affiche la date de création du commentaire -->
              <div v-if="validation" id="app">
                <span>
                  <button v-if="!comment.validated && !disableValidationButtons"
                          v-on:click="validateComment(comment)"
                          class="btn btn-sm btn-success">
                    Valider
                  </button>
                  <!-- Bouton pour valider un commentaire s'il n'est pas déjà validé -->
                  <i v-else-if="comment.validated" class="fas fa-check-circle text-success"></i>
                  <!-- Affiche une icône de vérification si le commentaire est validé -->
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
      // Affiche une alerte de succès
      Swal.fire('Vous avez validé ce commentaire!', '', 'success');
    },
    addComment() {
      // Ajoute un commentaire en appelant une API
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
      // Récupère les commentaires en appelant une API
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
      // Valide un commentaire en fonction de la longueur du texte
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
