<script setup>
import { RouterLink, RouterView } from 'vue-router'

</script>

<script>
import {UseUserStore} from "@/stores/UserStore.js";

export default {
  data(){
    return{
      userStore: UseUserStore()
    };
  },
  created() {
    this.userStore.fetchUser();
  }
}
</script>

<template>
  <router-view></router-view>
</template>

