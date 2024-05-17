<template>
  <nav class="navbar main-nav border-less fixed-top navbar-expand-lg p-0">
    <div class="container-fluid p-0">
      <!-- logo -->
      <router-link
          to="/" class="navbar-brand"><img src="/images/logo.png" alt="logo">
      </router-link>
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
                to="/contact" class="nav-link">Kontakt<span></span>
            </router-link>
          </li>
        </ul>
        <div v-if="!user.id">
          <router-link to="/register" class="ticket"><span>REGISTRÁCIA</span></router-link>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
import {UseAuthStore} from "@/stores/AuthStore.js";

export default {
  data(){
    return{
      authStore: UseAuthStore(),
      user: []
    };
  },
  created() {
    this.user = this.authStore.getUser
  }
}
</script>