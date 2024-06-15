<script setup>
import { RouterLink, RouterView } from 'vue-router'

</script>

<script>
import {UseUserStore} from "@/stores/UserStore.js";
import {UseConferenceStore} from "@/stores/ConferenceStore.js";

export default {
  data(){
    return{
      userStore: UseUserStore(),
      conferenceStore: UseConferenceStore()
    };
  },
  created() {
    this.userStore.fetchUser();
    this.conferenceStore.checkConference();
  }
}
</script>

<template>
  <router-view></router-view>
</template>

