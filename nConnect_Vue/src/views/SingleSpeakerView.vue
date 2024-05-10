<template>
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

  <section class="section single-speaker">
    <div class="container">
      <div class="block">
        <div class="row">
          <div class="col-lg-5 col-md-6 align-self-md-center">
            <div class="image-block">
              <img src="/images/speakers/single-speaker.jpg" class="img-fluid" alt="speaker">
            </div>
          </div>
          <div class="col-lg-7 col-md-6 align-self-center">
            <div class="content-block">
              <div class="name">
                <h3>Jonathan Franco</h3>
              </div>
              <div class="profession">
                <p>Web Developer</p>
              </div>
              <div class="details">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusm tempor incididunt ut labore dolore magna aliqua enim ad minim veniam quis nostrud.laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse.
                  Duis aute irure dolor in reprehenderit in voluptate velit esse.
                  <br>
                </p>
                <p>
                  Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.
                  <br>
                  Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur</p>
              </div>
              <div class="social-profiles">
                <h5>Social Profiles</h5>
                <ul class="list-inline social-list">
                  <li class="list-inline-item">
                    <a href="#"><i class="fa fa-twitter"></i></a>
                  </li>
                  <li class="list-inline-item">
                    <a href="#"><i class="fa fa-linkedin"></i></a>
                  </li>
                  <li class="list-inline-item">
                    <a href="#"><i class="fa fa-facebook"></i></a>
                  </li>
                  <li class="list-inline-item">
                    <a href="#"><i class="fa fa-skype"></i></a>
                  </li>
                  <li class="list-inline-item">
                    <a href="#"><i class="fa fa-pinterest-p"></i></a>
                  </li>
                </ul>
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