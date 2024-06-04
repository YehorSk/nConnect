<template>
  <nav class="navbar main-nav border-less fixed-top navbar-expand-lg p-0">
    <div class="container-fluid p-0">
      <!-- logo -->
      <router-link to="/" class="navbar-brand"><img src="/images/logo.png" alt="logo"></router-link>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="fa fa-bars"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item">
            <router-link
                to="/" class="nav-link">Domov<span>/</span>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link
                to="/speakers" class="nav-link">Speakers<span>/</span>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link
                to="/schedule" class="nav-link">Program<span>/</span>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link
                to="/sponsors" class="nav-link">Partneri<span>/</span>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link
                to="/gallery" class="nav-link">Galéria<span>/</span>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link
                to="/contact" class="nav-link">Kontakt<span>/</span>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link
                to="/pages" class="nav-link">Info<span></span>
            </router-link>
          </li>
        </ul>
        <div v-if="loading">
        </div>
        <div v-else>
          <div v-if="!user.id">
            <router-link to="/register" class="ticket"><span>REGISTRÁCIA</span></router-link>
          </div>
          <div v-else class="navbar-nav">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Môj profil
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#" v-if="user.is_admin === 0" @click.prevent="openConferenceDialog">Moje konferencie</a>
                <router-link v-if="user.is_admin === 1" to="/admin" class="dropdown-item">Admin</router-link>
                <a class="dropdown-item" href="#" @click.prevent="authStore.logout">Logout</a>
              </div>
            </li>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <v-dialog v-model="conference_dialog" max-width="600px">
    <v-card>
      <v-card-title>
        Moje konferencie
      </v-card-title>
      <v-card-text>
        <v-list>
          <v-list-item v-for="lecture in authStore.lectures" :key="lecture.id">
              <v-list-item-title>{{ lecture.name }}</v-list-item-title>
              <v-list-item-subtitle>{{ lecture.start_time }} - {{ lecture.end_time }}</v-list-item-subtitle>
              <v-list-item-subtitle>{{ 'Voľné miesta: ' + (lecture.capacity - lecture.remaining_spots) }}</v-list-item-subtitle>
            <v-list-item-action>
              <v-btn color="black" @click="removeLecture(lecture.id)">Odhlásiť sa</v-btn>
            </v-list-item-action>
          </v-list-item>
        </v-list>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn text @click="conference_dialog = false">Close</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import { UseAuthStore } from "@/stores/AuthStore.js";
import { useEditorStore } from "@/stores/EditorStore.js";
import { useLectureStore } from "@/stores/LectureStore.js";

export default {
  data() {
    return {
      authStore: UseAuthStore(),
      editorStore: useEditorStore(),
      lectureStore: useLectureStore(),
      user: {},
      conference_dialog: false,
      showRemovalAlert: false,
      loading: true,
    };
  },
  created() {
      this.user = this.authStore.getUser;
      if (this.user) {
        this.authStore.fetchLectures().finally(() => {
          this.loading = false;
        });
      } else {
        this.loading = false;
      }
  },

  methods: {
    openConferenceDialog() {
      this.conference_dialog = true;
    },
    removeLecture(lectureId) {
      this.authStore.deleteLecture(lectureId).then(() => {
        this.showRemovalAlert = true;
        setTimeout(() => {
          this.showRemovalAlert = false;
        }, 3000);
      });
    },
  },
};
</script>

<style scoped>
.navbar-nav .dropdown-menu {
  background-color: #fff;
  border-radius: 0;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  right: 0;
  left: auto;
}

.navbar-nav .dropdown-item {
  color: #333;
  padding: 10px 20px;
  transition: background-color 0.2s, color 0.2s;
}

.navbar-nav .dropdown-item:hover {
  background-color: #f8f9fa;
  color: #007bff;
}

.navbar-nav .dropdown-toggle::after {
  margin-left: .255em;
  vertical-align: .255em;
  content: "";
  border-top: .3em solid;
  border-right: .3em solid transparent;
  border-bottom: 0;
  border-left: .3em solid transparent;
}
</style>
