<template>
  <section class="banner bg-banner-one overlay">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <!-- Content Block -->
          <div class="block">
            <!-- Coundown Timer -->
<!--            <div class="timer"></div>-->
            <h1>{{ conferenceStore.getCurrentConference.name }}</h1>
            <h2>TECH KONFERENCIA PRE ŠTUDENTOV V NITRE</h2>
            <h6>{{ conferenceStore.getCurrentConference.year }}</h6>
            <!-- Action Button -->
            <div v-if="user.id">
              <div v-if="user.email_verified_at">
                <router-link  to="#" class="btn btn-white-md">Moje konferencie</router-link>
              </div>
              <div v-else-if="!user.email_verified_at">
                <h2>Please verify your email</h2>
              </div>

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
import { initFlowbite } from 'flowbite';
import {UseConferenceStore} from "@/stores/ConferenceStore.js";
export default {
  data(){
    return{
      authStore: UseAuthStore(),
      user: {},
      conferenceStore: UseConferenceStore(),
    };
  },
  created() {
    this.user = this.authStore.getUser;
    this.conferenceStore.fetchCurrentConference();
  },
  mounted() {
    initFlowbite();
  },
}
</script>