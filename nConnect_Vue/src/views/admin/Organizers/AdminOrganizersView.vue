<style scoped>
@import '/src/assets/main.css';
</style>
<template>
  <AdminNavComponent/>

  <div class="p-4 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
      <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <v-sheet class="max-w-sm">
          <v-form fast-fail @submit.prevent>
            <v-text-field
                v-model="name"
                label="Name"
                color="orange"
            ></v-text-field>
            <div v-if="organizersStore.error_name">
              <span class="text-sm text-red-400">
                {{organizersStore.error_name}}
              </span>
            </div>
            <v-text-field
                v-model="phone_number"
                label="Phone Number"
                color="orange"
            ></v-text-field>
            <div v-if="organizersStore.error_phone_number">
              <span class="text-sm text-red-400">
                {{organizersStore.error_phone_number}}
              </span>
            </div>
            <v-text-field
                v-model="email"
                label="Email"
                color="orange"
            ></v-text-field>
            <div v-if="organizersStore.error_email">
              <span class="text-sm text-red-400">
                {{organizersStore.error_email}}
              </span>
            </div>
            <v-file-input
                v-model="addFile"
                accept="image/png, image/jpeg, image/jpg, image/gif"
                :prepend-icon="null"
                color="orange"
                @change="onFileChange($event, 'add')"
                label="Choose Photo">
            </v-file-input>
            <div v-if="organizersStore.error_image">
              <span class="text-sm text-red-400">
                {{organizersStore.error_image}}
              </span>
            </div>
            <v-img v-if="addImageUrl" :src="addImageUrl" />
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
          <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
              <th scope="col" class="px-6 py-3">Photo</th>
              <th scope="col" class="px-6 py-3">Name</th>
              <th scope="col" class="px-6 py-3">Phone Number</th>
              <th scope="col" class="px-6 py-3">Email</th>
              <th scope="col" class="px-6 py-3">Update</th>
              <th scope="col" class="px-6 py-3">Delete</th>
            </tr>
            </thead>
            <tbody v-for="organizer in organizersStore.organizers.data" :key="organizer.id">
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
              <td class="px-6 py-4">
                <img :src="'https://api.nconnect.mojawebka.eu/nConnect-Laravel/storage/' + organizer.image" class="w-16 md:w-32 max-w-full max-h-full" alt="Organizer's Profile Picture">
                <form @submit.prevent class="inline-block mt-2">
                  <input type="hidden" v-model="organizer.id">
                  <input type="file" accept="image/*" @change="onFileChange($event,'update')" class="inline-block">
                </form>
              </td>
              <td class="px-6 py-4">
                <input type="text" v-model="organizer.name" placeholder="Name" class="inline-block w-full">
              </td>
              <td class="px-6 py-4">
                <input type="text" v-model="organizer.phone_number" placeholder="Phone Number" class="inline-block w-full">
              </td>
              <td class="px-6 py-4">
                <input type="text" v-model="organizer.email" placeholder="Email" class="inline-block w-full">
              </td>
              <td class="px-6 py-4">
                <v-btn @click="updateForm(organizer)"
                       color="green-lighten-2"
                       text="Update"
                ></v-btn>
              </td>
              <td class="px-6 py-4">
                <form @submit.prevent class="inline-block">
                  <v-btn @click="organizersStore.destroyOrganizers(organizer.id)"
                         color="red-lighten-2"
                         text="Delete"
                  ></v-btn>
                </form>
              </td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div v-if="organizersStore.success" id="alert-3" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
      <SuccessAlertComponent :message="organizersStore.success"/>
    </div>
    <div v-if="organizersStore.errors" id="alert-2" class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
      <ErrorAlertComponent :message="organizersStore.errors"/>
    </div>

    <div class="text-center">
      <v-pagination
          v-model="page"
          :length="organizersStore.organizers.last_page"
          rounded="circle"
      ></v-pagination>
    </div>

  </div>

</template>

<script>
import { onMounted, watch } from 'vue'
import { initFlowbite } from 'flowbite'
import AdminNavComponent from "@/components/AdminNavComponent.vue";
import SuccessAlertComponent from "@/components/alerts/SuccessAlertComponent.vue";
import ErrorAlertComponent from "@/components/alerts/ErrorAlertComponent.vue";
import { UseOrganizersStore } from "@/stores/OrganizersStore.js";

export default {
  components: { ErrorAlertComponent, SuccessAlertComponent, AdminNavComponent },
  data() {
    return {
      name: '',
      phone_number: '',
      email: '',
      addFile: null,
      updateFile: null,
      addImageUrl: "",
      updateImageUrl: "",
      search: '',
      page: 1,
      organizersStore: UseOrganizersStore(),
    };
  },
  created() {
    this.organizersStore.fetchOrganizers();
    this.organizersStore.success = '';
  },
  mounted() {
    initFlowbite();
    watch(() => this.page, (newValue, oldValue) => {
      if (newValue) {
        this.organizersStore.fetchOrganizers(this.page, this.search);
      }
    });
  },
  methods: {
    submitForm() {
      this.organizersStore.insertOrganizers(this.name, this.addFile, this.phone_number, this.email);
      this.name = '';
      this.phone_number = '';
      this.email = '';
      this.addFile = null;
      this.addImageUrl = "";
      this.organizersStore.error_name = '';
      this.organizersStore.error_email = '';
      this.organizersStore.error_phone_number = '';
      this.organizersStore.error_image = '';
    },
    updateForm(organizers) {
      console.log("File", this.file);
      this.organizersStore.updateOrganizer(organizers, this.updateFile);
    },
    createImage(file, form) {
      const reader = new FileReader();
      reader.onload = e => {
        if (form === 'update') {
          this.updateImageUrl = e.target.result;
        } else {
          this.addImageUrl = e.target.result;
        }
      };
      reader.readAsDataURL(file);
    },
    onFileChange(event, form) {
      const file = event.target.files[0];
      if (!file) {
        console.log("No file selected.");
        return;
      }
      if (form === 'update') {
        this.updateFile = file;
      } else {
        this.addFile = file;
      }
      this.createImage(file, form);
    },
    onSearch() {
      this.page = 1;
      this.organizersStore.fetchOrganizers(this.page, this.search);
    }
  }
}
</script>
