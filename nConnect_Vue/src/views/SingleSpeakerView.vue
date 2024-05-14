<template>
  <div>
    <NavigationComponent/>
    <section class="page-title bg-title overlay-dark">
      <div class="container">
        <div class="row">
          <div class="col-12 text-center">
            <div class="title">
              <h3>Speaker</h3>
            </div>
            <ol class="breadcrumb p-0 m-0">
              <li class="breadcrumb-item"><a href="index.html">Domov</a></li>
              <li class="breadcrumb-item active">Speaker</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <div v-if="speaker" class="container mt-4">
      <div class="row">
        <div class="col-md-4">
          <div class="speaker-image">
            <img :src="'http://127.0.0.1:8000/storage/' +speaker.picture" class="img-fluid" :alt="speaker.first_name + ' ' + speaker.last_name">
          </div>
        </div>
        <div class="col-md-8">
          <div class="name">
            <h3>{{ speaker.first_name }} {{ speaker.last_name }}</h3>
          </div>
          <div class="profession">
            <p>{{ speaker.company }}</p>
          </div>
          <div class="details">
            <p>{{ speaker.short_desc }}</p>
          </div>
          <div class="details">
            <p>{{ speaker.long_desc }}</p>
          </div>
          <div class="social-profiles">
            <h5>Social Profiles</h5>
            <ul class="list-inline social-list">
              <li v-if="speaker.twitter" class="list-inline-item"><a :href="speaker.twitter"><i class="fa fa-twitter"></i></a></li>
              <li v-if="speaker.linkedIn" class="list-inline-item"><a :href="speaker.linkedIn"><i class="fa fa-linkedin"></i></a></li>
              <li v-if="speaker.facebook" class="list-inline-item"><a :href="speaker.facebook"><i class="fa fa-facebook"></i></a></li>
              <li v-if="speaker.instagram" class="list-inline-item"><a :href="speaker.instagram"><i class="fa fa-instagram"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div v-else class="text-center mt-4">Loading...</div>
    <MapComponent/>
    <FooterComponent/>
  </div>
</template>

<script>
import axios from 'axios';
import FooterComponent from "@/components/FooterComponent.vue";
import MapComponent from "@/components/MapComponent.vue";
import NavigationComponent from "@/components/NavigationComponent.vue";
import { useSpeakersStore } from '@/stores/SpeakersStore';

export default {
  components: {NavigationComponent, FooterComponent, MapComponent},
  data() {
    return {
      speaker: null
    };
  },
  async created() {
    const speakersStore = useSpeakersStore();
    const speakerId = this.$route.params.id;
    try {
      this.speaker = await speakersStore.fetchSpeakerById(speakerId);
    } catch (error) {
      console.error('Error fetching speaker:', error);
    }
  }
};
</script>

<style scoped>
/* Add your custom styles here */
</style>
