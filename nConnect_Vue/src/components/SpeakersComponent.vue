<template>
  <section class="section speakers bg-speaker overlay-lighter">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <!-- Section Title -->
          <div class="section-title white">
            <h3>Speakers</h3>
          </div>
        </div>
      </div>
      <div class="row">
        <div v-for="speaker in speakersStore.getCurrentSpeakers" :key="speaker.id" class="col-lg-3 col-md-4 col-sm-6">
          <!-- Speaker 1 -->
          <div class="speaker-item">
            <div class="image">
              <img :src="'http://127.0.0.1:8000/storage/' + speaker.image" :alt="`${speaker.last_name}`" class="img-fluid">
              <div class="primary-overlay"></div>
              <div class="socials">
                <ul class="list-inline">
                  <li class="list-inline-item"><a :href="speaker.facebook"><i class="fa fa-facebook"></i></a></li>
                  <li class="list-inline-item"><a :href="speaker.twitter"><i class="fa fa-twitter"></i></a></li>
                  <li class="list-inline-item"><a :href="speaker.linkedIn"><i class="fa fa-linkedin"></i></a></li>
                  <li class="list-inline-item"><a :href="speaker.instagram"><i class="fa fa-instagram"></i></a></li>
                </ul>
              </div>
            </div>
            <div class="content text-center">
              <h5><router-link :to="`/single-speaker/${speaker.id}`">{{ speaker.first_name }} {{ speaker.last_name }}</router-link></h5>
              <p>{{ speaker.company }}</p>
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
import {useSpeakersStore} from "@/stores/SpeakersStore.js";

export default {
  data(){
    return {
      speakersStore: useSpeakersStore(),
    };
  },
  created(){
    this.speakersStore.fetchCurrentConferenceSpeakers();
  },
  mounted() {
    initFlowbite();
  }
  ,
}
</script>