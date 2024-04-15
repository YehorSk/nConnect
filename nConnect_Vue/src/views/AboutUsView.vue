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
  <section class="section about">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-6 align-self-center">
          <div class="image-block bg-about">
            <img class="img-fluid" src="/images/speakers/featured-speaker.jpg" alt="">
          </div>
        </div>
        <div class="col-lg-8 col-md-6 align-self-center">
          <div class="content-block">
            <h2>About The <span class="alternate">Eventre</span></h2>
            <div class="description-one">
              <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusm tempor incididunt ut labore dolore magna aliqua enim ad minim veniam quis nostrud exercitation ullamco.
              </p>
            </div>
            <div class="description-two">
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmtempor incididunt ut labore et dolore magna aliq enim ad minim veniam quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea.</p>
            </div>
            <ul class="list-inline">
              <li class="list-inline-item">
                <a href="#" class="btn btn-main-md">Buy ticket</a>
              </li>
              <li class="list-inline-item">
                <a href="#" class="btn btn-transparent-md">Read more</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>
  <SpeakersComponent/>
  <TestimonialVuew/>
  <ActionSubscribeComponent/>
  <MapComponent/>
  <FooterComponent/>
</template>
<script setup lang="ts">
import NavigationComponent from "@/components/NavigationComponent.vue";
import MapComponent from "@/components/MapComponent.vue";
import FooterComponent from "@/components/FooterComponent.vue";
import ActionSubscribeComponent from "@/components/ActionSubscribeComponent.vue";
import SpeakersComponent from "@/components/SpeakersComponent.vue";
import TestimonialVuew from "@/views/TestimonialVuew.vue";
</script>