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
            <button type="button" class="control mixitup-control-active" data-filter="all">All</button>
            <button type="button" class="control" data-filter=".conference">2025</button>
            <button type="button" class="control" data-filter=".meeting">2024</button>
          </div>
          <div class="gallery-wrapper">
            <div class="gallery-item mix meeting">
              <div class="image-block">
                <div class="image">
                  <img src="/images/gallery/gallery-one.jpg" alt="gallery-image" class="img-fluid">
                  <div class="primary-overlay">
                    <a class="image-popup" data-effect="mfp-with-zoom" href="/images/gallery/gallery-popup-one.jpg"><i class="fa fa-picture-o"></i></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="gallery-item mix party events">
              <div class="image-block">
                <div class="image">
                  <img src="/images/gallery/gallery-two.jpg" alt="gallery-image" class="img-fluid">
                  <div class="primary-overlay">
                    <a class="image-popup" data-effect="mfp-with-zoom" href="/images/gallery/gallery-popup-two.jpg"><i class="fa fa-picture-o"></i></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="gallery-item mix meeting party">
              <div class="image-block">
                <div class="image">
                  <img src="/images/gallery/gallery-three.jpg" alt="gallery-image" class="img-fluid">
                  <div class="primary-overlay">
                    <a class="image-popup" data-effect="mfp-with-zoom" href="/images/gallery/gallery-popup-three.jpg"><i class="fa fa-picture-o"></i></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="gallery-item mix meeting concert">
              <div class="image-block">
                <div class="image">
                  <img src="/images/gallery/gallery-four.jpg" alt="gallery-image" class="img-fluid">
                  <div class="primary-overlay">
                    <a class="image-popup" data-effect="mfp-with-zoom" href="/images/gallery/gallery-popup-four.jpg"><i class="fa fa-picture-o"></i></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="gallery-item mix concert party">
              <div class="image-block">
                <div class="image">
                  <img src="/images/gallery/gallery-five.jpg" alt="gallery-image" class="img-fluid">
                  <div class="primary-overlay">
                    <a class="image-popup" data-effect="mfp-with-zoom" href="/images/gallery/gallery-popup-five.jpg"><i class="fa fa-picture-o"></i></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="gallery-item mix events conference">
              <div class="image-block">
                <div class="image">
                  <img src="/images/gallery/gallery-six.jpg" alt="gallery-image" class="img-fluid">
                  <div class="primary-overlay">
                    <a class="image-popup" data-effect="mfp-with-zoom" href="/images/gallery/gallery-popup-six.jpg"><i class="fa fa-picture-o"></i></a>
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
<script setup lang="ts">
import NavigationComponent from "@/components/NavigationComponent.vue";
import FooterComponent from "@/components/FooterComponent.vue";
import MapComponent from "@/components/MapComponent.vue";
</script>