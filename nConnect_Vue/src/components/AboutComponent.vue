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
            <ul class="list-inline">
              <div v-if="!user.id">
                <li class="list-inline-item">
                  <router-link to="/register" class="btn btn-main-md">REGISTRÁCIA</router-link>
                </li>
              </div>
              <div v-else>
                <div v-if="user.is_admin === 0">
                  <div v-if="conferenceStore.has_current === false">
                    <li class="list-inline-item">
                      <button @click="conferenceStore.addConference()" class="btn btn-main-md">Registrácia na konferenciu</button>
                    </li>
                  </div>
                  <div v-else-if="conferenceStore.has_current === true">
                    <li class="list-inline-item">
                      <button @click="conferenceStore.removeConference(), userStore.fetchLectures()" class="btn btn-main-md">Odhlásenie z konferencie</button>
                    </li>
                  </div>
                </div>
              </div>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

</template>

<script>
import {UseUserStore} from "@/stores/UserStore.js";
import {UseConferenceStore} from "@/stores/ConferenceStore.js";

export default {
  data(){
    return{
      userStore: UseUserStore(),
      conferenceStore: UseConferenceStore(),
      user: {}
    };
  },
  created() {
    this.user = this.userStore.getUser;
  }
}
</script>