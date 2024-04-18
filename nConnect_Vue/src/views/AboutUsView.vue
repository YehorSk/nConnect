<template>
  <NavigationComponent/>
  <section class="page-title bg-title overlay-dark">
    <div class="container">
      <div class="row">
        <div class="col-12 text-center">
          <div class="title">
            <h3>About Us</h3>
          </div>
          <ol class="breadcrumb p-0 m-0">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">About US</li>
          </ol>
        </div>
      </div>
    </div>
  </section>
  <AboutComponent/>
  <SpeakersComponent/>
  <TestimonialVuew/>
  <MapComponent/>
  <FooterComponent/>
</template>
<script setup lang="ts">
import NavigationComponent from "@/components/NavigationComponent.vue";
import MapComponent from "@/components/MapComponent.vue";
import FooterComponent from "@/components/FooterComponent.vue";
import SpeakersComponent from "@/components/SpeakersComponent.vue";
import TestimonialVuew from "@/views/TestimonialView.vue";
import AboutComponent from "@/components/AboutComponent.vue";
</script>