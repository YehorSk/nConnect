<script setup>
import { RouterLink, RouterView } from 'vue-router'

</script>

<script>
import {UseAuthStore} from "@/stores/AuthStore.js";

export default {
  data(){
    return{
      authStore: UseAuthStore()
    };
  },
  created() {
    this.authStore.fetchUser();
  }
}
</script>

<template>
  <router-view></router-view>
</template>

