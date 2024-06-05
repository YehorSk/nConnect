<style scoped>
@import '/src/assets/main.css';
</style>
<template>
  <NavigationComponent/>
  <section class="bg-gray-50 dark:bg-gray-900">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
      <div class="w-full p-6 bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md dark:bg-gray-800 dark:border-gray-700 sm:p-8">
        <h2 class="mb-1 text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
          Change Password
        </h2>
        <form class="mt-4 space-y-4 lg:mt-5 md:space-y-5" @submit.prevent>
          <div>
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
            <input type="email" name="email" id="email" v-model="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" required="">
          </div>
          <button type="submit" @click="submitForm" class="w-full bg-blue-500 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 text-white font-semibold py-2 px-4 rounded">
            Reset password
          </button>
        </form>
        <div v-if="authStore.success" id="alert-3" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
          <SuccessAlertComponent :message="authStore.success"/>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
import NavigationComponent from "@/components/NavigationComponent.vue";
import {UseAuthStore} from "@/stores/AuthStore.js";
import { initFlowbite } from 'flowbite'
import SuccessAlertComponent from "@/components/alerts/SuccessAlertComponent.vue";
export default {
  components:{SuccessAlertComponent, NavigationComponent},
  data(){
    return{
      authStore: UseAuthStore(),
      email: ''
    }
  },
  mounted() {
    initFlowbite();
  },
  methods:{
    submitForm(){
      this.authStore.forgot_password(this.email);
    }
  }
}
</script>