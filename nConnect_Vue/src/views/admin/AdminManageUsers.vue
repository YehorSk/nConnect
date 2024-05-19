<style scoped>
@import '/src/assets/main.css';
</style>
<template>
  <AdminNavComponent/>
  <div class="p-4 sm:ml-64 ">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">

      <h1>Users</h1>
      <br>
      <div class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">

        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th scope="col" class="px-16 py-3">
              Name
            </th>
            <th scope="col" class="px-6 py-3">
              Email
            </th>
            <th scope="col" class="px-6 py-3">
              Email verified at
            </th>
          </tr>
          </thead>
          <tbody v-for="users in authStore.getRegularUsers" :key="users.id">
          <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <td>
              {{users.name}}
            </td>
            <td>
              {{users.email}}
            </td>
            <td>
              {{users.email_verified_at}}
            </td>
          </tr>

          </tbody>
        </table>
        </div>


    </div>

  </div>
</template>
<script>
import { initFlowbite } from 'flowbite'
import AdminNavComponent from "@/components/AdminNavComponent.vue";
import {defineComponent} from "vue";
import ErrorAlertComponent from "@/components/alerts/ErrorAlertComponent.vue";
import SuccessAlertComponent from "@/components/alerts/SuccessAlertComponent.vue";
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
    this.authStore.fetchRegularUsers();
  },
  mounted() {
    initFlowbite();
  }


}

</script>