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
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">New Password</label>
            <input type="password" v-model="new_pwd" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
          </div>
          <div>
            <label for="confirm-password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm password</label>
            <input type="confirm-password" v-model="confirm_new_pwd" name="confirm-password" id="confirm-password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
          </div>
          <button type="submit" @click="submitForm" class="w-full bg-blue-500 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 text-white font-semibold py-2 px-4 rounded">
            Reset password
          </button>
        </form>
        <div v-if="authStore.success" id="alert-3" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
          <SuccessAlertComponent :message="authStore.success"/>
        </div>
        <div v-if="authStore.errors" id="alert-2" class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
          <ErrorAlertComponent :message="authStore.errors"/>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
import NavigationComponent from "@/components/NavigationComponent.vue";
import { initFlowbite } from 'flowbite'
import {useRoute} from "vue-router";
import {UseAuthStore} from "@/stores/AuthStore.js";
import SuccessAlertComponent from "@/components/alerts/SuccessAlertComponent.vue";
import ErrorAlertComponent from "@/components/alerts/ErrorAlertComponent.vue";

export default {
  components:{ErrorAlertComponent, SuccessAlertComponent, NavigationComponent},
  data(){
    return{
      authStore: UseAuthStore(),
      new_pwd:'',
      confirm_new_pwd:'',
      route: useRoute(),
    }
  },
  mounted() {
    initFlowbite();
  },
  methods:{
    submitForm(){
      this.authStore.reset_password(this.new_pwd,this.confirm_new_pwd,this.route.query.email,this.route.params.token);
    }
  }
}
</script>