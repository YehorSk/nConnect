<style scoped>
@import '/src/assets/main.css';
</style>
<template>
  <AdminNavComponent />

  <div class="p-4 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
      <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <v-sheet class="max-w-sm">
          <v-form fast-fail @submit.prevent>
            <v-select
                :item-props="itemProps"
                color="orange"
                v-model="sponsor"
                :items="sponsorsStore.getAvailableSponsors"
                label="Available Sponsors"
            ></v-select>
            <v-btn class="mt-2" type="submit" @click="submitForm()" block>Save</v-btn>
          </v-form>
        </v-sheet>

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
        <div class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
          <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
              <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
              <tr>
                <th scope="col" class="px-16 py-3">Image</th>
                <th scope="col" class="px-6 py-3">Name</th>
                <th scope="col" class="px-6 py-3">Link</th>
                <th scope="col" class="px-6 py-3">Delete</th>
              </tr>
              </thead>
              <tbody v-for="sponsor in sponsorsStore.current_sponsors.data" :key="sponsor.id">
              <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="p-4">
                  <img :src="'https://api.nconnect.mojawebka.eu/nConnect-Laravel/storage/' + sponsor.image" class="w-32 md:w-64 max-w-full max-h-full" alt="Sponsor Image">
                </td>
                <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">{{sponsor.name}}</td>
                <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">{{sponsor.link}}</td>
                <td>
                  <form @submit.prevent class="inline-block">
                    <v-btn @click="sponsorsStore.deleteSponsorFromConference(sponsor.id)" color="red-lighten-2" text="Delete"></v-btn>
                  </form>
                </td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div v-if="sponsorsStore.success" id="alert-3" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
      <SuccessAlertComponent :message="sponsorsStore.success" />
    </div>

    <div class="text-center">
      <v-pagination v-model="page" :length="sponsorsStore.current_sponsors.last_page" rounded="circle"></v-pagination>
    </div>
  </div>
</template>

<script>
import { onMounted, watch } from 'vue';
import { initFlowbite } from 'flowbite';
import AdminNavComponent from "@/components/AdminNavComponent.vue";
import SuccessAlertComponent from "@/components/alerts/SuccessAlertComponent.vue";
import ErrorAlertComponent from "@/components/alerts/ErrorAlertComponent.vue";
import { useSponsorsStore } from "@/stores/SponsorsStore.js";

export default {
  components: { ErrorAlertComponent, SuccessAlertComponent, AdminNavComponent },
  data() {
    return {
      sponsor: [],
      search: '',
      page: 1,
      sponsorsStore: useSponsorsStore(),
    };
  },
  created() {
    this.sponsorsStore.fetchSponsors();
    this.sponsorsStore.fetchCurrentConferenceSponsors();
    this.sponsorsStore.fetchAvailableSponsors();
    this.sponsorsStore.success = '';
  },
  mounted() {
    initFlowbite();
    watch(() => this.page, (newValue, oldValue) => {
      if (newValue) {
        this.sponsorsStore.fetchCurrentConferenceSponsors(this.page, this.search);
      }
    });
  },
  methods: {
    submitForm() {
      this.sponsorsStore.addSponsorToConference(this.sponsor.id);
      this.sponsor = [];
    },
    itemProps(item) {
      return {
        title: item.name,
        subtitle: item.link,
      };
    },
    onSearch() {
      this.page = 1;
      this.sponsorsStore.fetchCurrentConferenceSponsors(this.page, this.search);
    },
  },
};
</script>

