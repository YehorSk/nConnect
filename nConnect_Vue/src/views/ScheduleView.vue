<template>
  <NavigationComponent/>
  <section class="page-title bg-title overlay-dark">
    <div class="container">
      <div class="row">
        <div class="col-12 text-center">
          <div class="title">
            <h3>Event Schedule</h3>
          </div>
          <ol class="breadcrumb p-0 m-0">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Event Schedule</li>
          </ol>
        </div>
      </div>
    </div>
  </section>
  <ScheduleComponent/>
  <ActionSubscribeComponent/>
  <MapComponent/>
  <FooterComponent/>
</template>
<script setup lang="ts">
import NavigationComponent from "@/components/NavigationComponent.vue";
import ScheduleComponent from "@/components/ScheduleComponent.vue";
import ActionSubscribeComponent from "@/components/ActionSubscribeComponent.vue";
import FooterComponent from "@/components/FooterComponent.vue";
import MapComponent from "@/components/MapComponent.vue";
</script>