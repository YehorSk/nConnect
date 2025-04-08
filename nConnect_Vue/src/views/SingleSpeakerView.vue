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
              <li class="breadcrumb-item"><a href="index.html">Home</a></li>
              <li class="breadcrumb-item active">Speaker</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <div v-if="speaker" class="container mt-5">
      <div class="row">
        <div class="col-md-4">
          <div class="speaker-image">
            <img :src="'https://api.nconnect.mojawebka.eu/nConnect-Laravel/storage/' + speaker.picture" class="img-fluid rounded shadow" :alt="speaker.first_name + ' ' + speaker.last_name">
          </div>
        </div>
        <div class="col-md-8">
          <div class="name mt-3">
            <h2>{{ speaker.first_name }} {{ speaker.last_name }}</h2>
          </div>
          <div class="profession mb-3">
            <h4>{{ speaker.company }}</h4>
          </div>
          <div class="details mb-3">
            <p>{{ speaker.short_desc }}</p>
          </div>
          <div class="details">
            <p>{{ speaker.long_desc }}</p>
          </div>
          <div class="social-profiles mt-4">
            <h5>Social Profiles</h5>
            <ul class="list-inline social-list">
              <li v-if="speaker.twitter" class="list-inline-item"><a :href="speaker.twitter" class="social-icon twitter"><i class="fa fa-twitter"></i></a></li>
              <li v-if="speaker.linkedIn" class="list-inline-item"><a :href="speaker.linkedIn" class="social-icon linkedin"><i class="fa fa-linkedin"></i></a></li>
              <li v-if="speaker.facebook" class="list-inline-item"><a :href="speaker.facebook" class="social-icon facebook"><i class="fa fa-facebook"></i></a></li>
              <li v-if="speaker.instagram" class="list-inline-item"><a :href="speaker.instagram" class="social-icon instagram"><i class="fa fa-instagram"></i></a></li>
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
.page-title {
  background-size: cover;
  padding: 100px 0;
  color: #fff;
  position: relative;
}

.page-title .overlay-dark {
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background: rgba(0, 0, 0, 0.5);
}

.title h3 {
  font-size: 36px;
  font-weight: 700;
  margin-bottom: 10px;
}

.breadcrumb {
  background: none;
  padding: 0;
}

.breadcrumb-item a {
  color: #fff;
}

.container {
  padding-top: 30px;
  padding-bottom: 30px;
}

.speaker-image img {
  width: 100%;
  height: auto;
  border-radius: 15px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.name h2 {
  font-size: 30px;
  font-weight: 600;
  color: #333;
}

.profession h4 {
  font-size: 22px;
  font-weight: 400;
  color: #777;
}

.details p {
  font-size: 16px;
  color: #555;
  line-height: 1.6;
}

.social-profiles h5 {
  font-size: 18px;
  font-weight: 500;
  margin-top: 20px;
  color: #333;
}

.social-list li {
  margin-right: 10px;
}

.social-list li a {
  font-size: 24px;
  color: #fff;
  display: inline-block;
  width: 50px;
  height: 50px;
  border-radius: 50%;
  line-height: 50px;
  text-align: center;
  transition: all 0.3s ease-in-out;
}

.social-list li a.twitter {
  background: #1DA1F2;
}

.social-list li a.linkedin {
  background: #0077b5;
}

.social-list li a.facebook {
  background: #3b5998;
}

.social-list li a.instagram {
  background: #e4405f;
}

.social-list li a:hover {
  transform: scale(1.1);
}
</style>
