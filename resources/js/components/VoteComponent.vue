<template>
    <!-- Colonne de la carte pour les votes -->
    <div class="col-md-2">
      <div class="card shadow">
        <!-- En-tête de la carte avec la flèche vers le haut (vote positif) -->
        <div class="card-header text-center">
          <!-- Icône de flèche vers le haut (font awesome) avec un style pour le curseur et gestion de clic -->
          <i class="fas fa-chevron-up fw-bold" style="cursor: pointer" @click="voteUp"></i>
        </div>
  
        <!-- Corps de la carte avec le nombre de votes -->
        <div class="card-body text-center">
          <!-- Texte en gras pour afficher le nombre de votes de la question -->
          <span class="fw-bold">{{ questionVotes }}</span>
        </div>
  
        <!-- Pied de la carte avec la flèche vers le bas (vote négatif) -->
        <div class="card-footer text-center">
          <!-- Icône de flèche vers le bas (font awesome) avec un style pour le curseur et gestion de clic -->
          <i class="fas fa-chevron-down fw-bold" style="cursor: pointer" @click="voteDown"></i>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  // Import d'Axios pour les appels API
  import axios from 'axios';
  
  export default {
    props: ['votes', 'id'], // Propriétés reçues par le composant
    data() {
      return {
        questionVotes: 0, // Le nombre de votes de la question
      };
    },
    mounted() {
      this.questionVotes = this.votes; // Initialiser les votes de la question avec les votes reçus
    },
    methods: {
      // Méthode pour voter vers le haut
      voteUp() {
        axios
          .get(`/api/questions/${this.id}/voteup`) // Appel GET à l'API pour voter positivement
          .then((res) => {
            this.questionVotes++; // Incrémenter le nombre de votes de la question
          })
          .catch((err) => console.log(err));
      },
      // Méthode pour voter vers le bas
      voteDown() {
        axios
          .get(`/api/questions/${this.id}/votedown`) // Appel GET à l'API pour voter négativement
          .then((res) => {
            this.questionVotes--; // Décrémenter le nombre de votes de la question
          })
          .catch((err) => console.log(err));
      },
    },
  };
  </script>
  