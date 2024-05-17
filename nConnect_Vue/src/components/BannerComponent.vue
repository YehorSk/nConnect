<template>
  <section class="banner bg-banner-one overlay">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <!-- Content Block -->
          <div class="block">
            <!-- Coundown Timer -->
<!--            <div class="timer"></div>-->
            <h1>nCONNECT24</h1>
            <h2>TECH KONFERENCIA PRE ŠTUDENTOV V NITRE</h2>
            <h6>14 MAREC 2024 , NITRA</h6>
            <!-- Action Button -->
            <div v-if="user.id">
              <router-link to="#" class="btn btn-white-md">Moje konferencie</router-link>
              <div v-if="user.is_admin===1">
                <router-link to="/admin" class="btn btn-white-md">Admin</router-link>
              </div>
              <div>
                <button @click="authStore.logout" class="p-3 text-white">Logout</button>
              </div>
            </div>
            <div v-else>
              <router-link to="/register" class="btn btn-white-md">Registrácia</router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
import {UseAuthStore} from "@/stores/AuthStore.js";

export default {
  data(){
    return{
      authStore: UseAuthStore(),
      user: {}
    };
  },
  created() {
    this.user = this.authStore.getUser;
  }
}
</script>