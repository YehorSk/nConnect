<template>
  <section class="sponsors section bg-sponsors overlay-white">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="section-title">
            <h3>Naši <span class="alternate">partneri</span></h3>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <!-- Title -->
          <div class="block text-center">
            <!-- Sponsors image list -->
            <ul class="list-inline sponsors-list">
              <li v-for="sponsor in sponsorsStore.getCurrentSponsorsAll" :key="sponsor.id" class="list-inline-item">
                <div class="image-block text-center">
                  <a :href="sponsor.link">
                    <img loading="lazy" :src="'https://api.nconnect.mojawebka.eu/nConnect-Laravel/public/storage/' + sponsor.image" :alt="`${sponsor.name}`" class="img-fluid">
                  </a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

</template>
<script>
import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'
import {useStageStore} from "@/stores/StageStore.js";
import AdminNavComponent from "@/components/AdminNavComponent.vue";
import SuccessAlertComponent from "@/components/alerts/SuccessAlertComponent.vue";
import ErrorAlertComponent from "@/components/alerts/ErrorAlertComponent.vue";
import {useSponsorsStore} from "@/stores/SponsorsStore.js";


export default {
  components: {ErrorAlertComponent, SuccessAlertComponent, AdminNavComponent},
  data(){
    return {
      sponsorsStore: useSponsorsStore(),
    };
  },
  created(){
    this.sponsorsStore.fetchCurrentConferenceSponsorsAll();
  },
  mounted() {
    initFlowbite();
  }
  ,
}
</script>