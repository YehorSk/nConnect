<template>
  <section class="section about">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-6 align-self-center">
          <div class="image-block bg-about">
            <img class="img-fluid" src="/images/background/about-logo.jpg" alt="">
          </div>
        </div>
        <div class="col-lg-8 col-md-6 align-self-center">
          <div class="content-block">
            <h2>PÁR SLOV O KONFERENCII <span class="alternate">NCONNECT</span></h2>
            <div class="description-one">
              <p>
                Po mnohých rokoch premýšľania a plánovania sme vytvorili nConnect, jedinečnú udalosť v Nitre, ktorá spája študentov IT a popredné firmy z tohto dynamického odvetvia. Konferencia nConnect nadväzuje na dlhoročnú tradíciu formátu "IT v praxi" Fakulty prírodných vied a informatiky UKF v Nitre. Táto iniciatíva je mostom medzi novou generáciou talentov a skúsenými profesionálmi, ktorý poskytuje fórum pre vzájomnú výmenu myšlienok a inšpirácií. Naše poslanie bolo jasné: vyplniť medzeru v regionálnej komunikácii a spolupráci v IT a nConnect je hrdým výsledkom tejto vízie.
              </p>
            </div>
<!--            <div class="description-two">-->
<!--              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmtempor incididunt ut labore et dolore magna aliq enim ad minim veniam quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea.</p>-->
<!--            </div>-->
            <ul class="list-inline">
              <div v-if="!user.id">
                <li class="list-inline-item">
                  <router-link to="/register" class="btn btn-main-md">REGISTRÁCIA</router-link>
                </li>
              </div>
<!--              <li class="list-inline-item">-->
<!--                <a href="#" class="btn btn-transparent-md">Read more</a>-->
<!--              </li>-->
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

</template>

<script>
import {UseAuthStore} from "@/stores/AuthStore.js";

export default {
  data(){
    return{
      authStore: UseAuthStore(),
      user: {}
    };
  },
  created() {
    this.user = this.authStore.getUser;
  }
}
</script>