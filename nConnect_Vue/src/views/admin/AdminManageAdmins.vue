<style scoped>
@import '/src/assets/main.css';
</style>
<template>
  <AdminNavComponent/>
  <div class="p-4 sm:ml-64 ">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
      <div class="relative overflow-x-auto">
        <h1>Admins</h1>
        <br>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th scope="col" class="px-6 py-3">
              Name
            </th>
            <th scope="col" class="px-6 py-3">
              Email
            </th>
            <th scope="col" class="px-6 py-3">
              Email verified at
            </th>
            <th scope="col" class="px-6 py-3">
              Remove admin
            </th>
          </tr>
          </thead>
          <tbody v-for="users in authStore.getAdminUsers" :key="users.id">
          <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
              {{ users.name }}
            </th>
            <td class="px-6 py-4">
              {{ users.email }}
            </td>
            <td class="px-6 py-4">
              {{ users.email_verified_at }}
            </td>
            <td class="px-6 py-4">
              <v-btn @click="authStore.removeAdminUser(users.id)"
                     color="red-lighten-2"
                     text="Remove"
              ></v-btn>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div v-if="authStore.success" id="alert-3" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
      <SuccessAlertComponent :message="authStore.success"/>
    </div>
    <div v-if="authStore.errors" id="alert-2" class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
      <ErrorAlertComponent :message="authStore.errors"/>
    </div>
  </div>
</template>
<script>
import { initFlowbite } from 'flowbite'
import AdminNavComponent from "@/components/AdminNavComponent.vue";
import {defineComponent} from "vue";
import SuccessAlertComponent from "@/components/alerts/SuccessAlertComponent.vue";
import ErrorAlertComponent from "@/components/alerts/ErrorAlertComponent.vue";
import {UseAuthStore} from "@/stores/AuthStore.js";
export default {
  components: {ErrorAlertComponent, SuccessAlertComponent, AdminNavComponent},
  data(){
    return {
      name: '',
      email: '',
      email_verified_at: '',
      errors: [],
      authStore: UseAuthStore(),
    };

  },
  created() {
    this.authStore.fetchAdminUsers();
  },
  mounted() {
    initFlowbite();
  },
  methods:{
    async removeAdminUser(userId) {
      await this.authStore.removeAdminUser(userId);
    }
  }


}

</script>