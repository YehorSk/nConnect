<template>
  <NavigationComponent/>
  <section class="page-title bg-title overlay-dark">
    <div class="container">
      <div class="row">
        <div class="col-12 text-center">
          <div class="title">
            <h3>Naša Galéria</h3>
          </div>
          <ol class="breadcrumb p-0 m-0">
            <li class="breadcrumb-item"><a href="index.html">Domov</a></li>
            <li class="breadcrumb-item active">Naša Galéria</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="section gallery">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="controls">
            <button type="button"  class="control mixitup-control-active" @click="filterByYear('all')">All</button>
            <button type="button" class="control" @click="filterByYear(2025)">2025</button>
            <button type="button" class="control" @click="filterByYear(2024)">2024</button>
          </div>
          <div class="gallery-wrapper">
            <div v-for="gallery in filteredGallery" :key="gallery.id" class="gallery-item mix {{ gallery.year }}">
              <div class="image-block">
                <div class="image">
                  <img :src="'https://api.nconnect.mojawebka.eu/nConnect-Laravel/storage/' + gallery.image" :alt="`gallery-image-${gallery.id}`" class="img-fluid">
                  <div class="primary-overlay">
                    <a class="image-popup" data-effect="mfp-with-zoom" :href="'https://api.nconnect.mojawebka.eu/nConnect-Laravel/storage/' + gallery.image"><i class="fa fa-picture-o"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <MapComponent/>
  <FooterComponent/>
</template>

<script>
import ErrorAlertComponent from "@/components/alerts/ErrorAlertComponent.vue";
import SuccessAlertComponent from "@/components/alerts/SuccessAlertComponent.vue";
import {initFlowbite} from "flowbite";
import {UseGalleryStore} from "@/stores/GalleryStore.js";
import NavigationComponent from "@/components/NavigationComponent.vue";
import FooterComponent from "@/components/FooterComponent.vue";
import MapComponent from "@/components/MapComponent.vue";

export default {
  components: {
    NavigationComponent,
    MapComponent,
    FooterComponent,
    ErrorAlertComponent,
    SuccessAlertComponent
  },
  data(){
    return {
      galleryStore: UseGalleryStore(),
      filteredGallery: [],
    };
  },
  created(){
    this.galleryStore.fetchGalleryAll();
  },
  mounted() {
    initFlowbite();
  },
  watch: {
    'galleryStore.gallery': function(newGallery) {
      this.filterByYear('all');
    }
  },
  methods: {
    filterByYear(year) {
      if (year === 'all') {
        this.filteredGallery = this.galleryStore.gallery;
      } else {
        this.filteredGallery = this.galleryStore.gallery.filter(gallery => gallery.year === year);
      }
    },
  },
}
</script>
