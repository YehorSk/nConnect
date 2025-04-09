<template>
  <section class="section speakers bg-speaker overlay-lighter">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <!-- Section Title -->
          <div class="section-title white">
            <h3>Organizátori</h3>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div v-for="organizer in organizersStore.getCurrentOrganizersAll" :key="organizer.id" class="col-lg-3 col-md-4 col-sm-6 mx-auto">
          <!-- Organizer 1 -->
          <div class="speaker-item">
            <div class="image">
              <img loading="lazy" :src="'https://api.nconnect.mojawebka.eu/nConnect-Laravel/public/storage/' + organizer.image" :alt="`${organizer.name}`" class="img-fluid">
            </div>
            <div class="content text-center">
              <h5>{{ organizer.name }}</h5>
              <p>{{ organizer.phone_number }}</p>
              <p>{{ organizer.email }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'
import {UseOrganizersStore} from "@/stores/OrganizersStore.js";

export default {
  data(){
    return {
      organizersStore: UseOrganizersStore(),
    };
  },
  created(){
    this.organizersStore.fetchCurrentConferenceOrganizersAll();
  },
  mounted() {
    initFlowbite();
  }
  ,
}
</script>