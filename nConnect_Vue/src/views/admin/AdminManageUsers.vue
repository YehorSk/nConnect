<style scoped>
@import '/src/assets/main.css';
</style>
<template>
  <AdminNavComponent/>
  <div class="p-4 sm:ml-64 ">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
      <div class="relative overflow-x-auto">
        <h1>Users</h1>
        <br>
        <form class="flex items-center max-w-sm mx-auto" @submit.prevent="onSearch">
          <div class="relative w-full">
            <input type="text" v-model="search" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search..." required />
          </div>
          <button type="submit" class="p-2.5 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
            </svg>
            <span class="sr-only">Search</span>
          </button>
        </form>
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
              Add admin
            </th>

          </tr>
          </thead>
          <tbody v-for="users in authStore.getRegularUsers.data" :key="users.id">
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
              <v-btn @click="authStore.addAdminUser(users.id)"
                     color="green-lighten-2"
                     class="white--text"
                     text="Add"
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
    <div class="text-center">
      <v-pagination
          v-model="page"
          :length="authStore.getRegularUsers.last_page"
          rounded="circle"
      ></v-pagination>
    </div>
  </div>
</template>
<script>
import { initFlowbite } from 'flowbite'
import AdminNavComponent from "@/components/AdminNavComponent.vue";
import {defineComponent, watch} from "vue";
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
      page: 1,
      search: '',
      authStore: UseAuthStore(),

    };
  },
  created() {
    this.authStore.fetchRegularUsers();
  },
  mounted() {
    initFlowbite();
    watch(() => this.page, (newValue, oldValue) => {
      if (newValue) {
        this.authStore.fetchRegularUsers(this.page, this.search)
      }
    });
  },
  methods: {
    onSearch() {
      this.page = 1;
      this.authStore.fetchRegularUsers(this.page, this.search);
    },
    async addAdminUser(userId) {
      await this.authStore.addAdminUser(userId);
    }
  }


}

</script>