<template>
  <section class="banner bg-banner-one overlay">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <!-- Content Block -->
          <div class="block text-container">
            <!-- Countdown Timer -->
            <!-- <div class="timer"></div> -->
            <h1>{{ conferenceStore.getCurrentConference.name }}</h1>
            <h2>TECH KONFERENCIA </h2>
            <h2>PRE ŠTUDENTOV V NITRE</h2>
            <h6>{{ conferenceStore.getCurrentConference.year }}</h6>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { initFlowbite } from 'flowbite';
import { UseConferenceStore } from "@/stores/ConferenceStore.js";
export default {
  data() {
    return {
      conferenceStore: UseConferenceStore(),
    };
  },
  created() {
    this.conferenceStore.fetchCurrentConference();
  },
  mounted() {
    initFlowbite();
  },
};
</script>

<style scoped>
.banner {
  position: relative;
  margin-top: 110px;
}

.text-container {
  position: absolute;
  bottom: -160px;
}

</style>
