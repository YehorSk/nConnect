<template>
  <NavigationComponent/>
  <section class="page-title bg-title overlay-dark">
    <div class="container">
      <div class="row">
        <div class="col-12 text-center">
          <div class="section-title">
            <h3>Informacie</h3>
          </div>
          <ol class="breadcrumb p-0 m-0">
            <li class="breadcrumb-item"><a href="index.html">Domov</a></li>
            <li class="breadcrumb-item active">Informacie</li>
          </ol>
        </div>
      </div>
    </div>
  </section>
  <PagesComponent/>
  <FooterComponent/>
</template>

<script>
import FooterComponent from "@/components/FooterComponent.vue";
import NavigationComponent from "@/components/NavigationComponent.vue";
import PagesComponent from "@/components/PagesComponent.vue";

export default {
  components: {
    FooterComponent,
    NavigationComponent,
    PagesComponent
  }
}
</script>