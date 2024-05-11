<style scoped>
@import '/src/assets/main.css';
</style>
<template>
  <AdminNavComponent/>

  <div class="p-4 sm:ml-64 ">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">


      <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

        <v-sheet class="max-w-sm ">
          <v-form fast-fail @submit.prevent >
            <v-text-field
                v-model="name"
                label="Name"
            ></v-text-field>
            <div v-if="organizersStore.error_name">
              <span class="text-sm text-red-400">
                {{organizersStore.error_name}}
              </span>
            </div>
            <v-text-field
                v-model="phone_number"
                label="Phone Number	"
            ></v-text-field>
            <div v-if="organizersStore.error_phone_number">
              <span class="text-sm text-red-400">
                {{organizersStore.error_phone_number}}
              </span>
            </div>
            <v-text-field
                v-model="email"
                label="Email"
            ></v-text-field>
            <div v-if="organizersStore.error_email">
              <span class="text-sm text-red-400">
                {{organizersStore.error_email}}
              </span>
            </div>
            <v-file-input
                v-model="file"
                accept="image/png, image/jpeg, image/jpg, image/gif"
                :prepend-icon="null"
                color="black"
                @change="onFileChange"
                label="Choose Photo">
            </v-file-input>
            <div v-if="organizersStore.error_image">
              <span class="text-sm text-red-400">
                {{organizersStore.error_image}}
              </span>
            </div>
            <v-img :src="imageUrl" />
            <v-btn class="mt-2" type="submit" @click="submitForm()" block>Save</v-btn>
          </v-form>
        </v-sheet>

        <br>
        <div class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">

          <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
              <th scope="col" class="px-16 py-3">
                Photo
              </th>
              <th scope="col" class="px-6 py-3">
                Name
              </th>
              <th scope="col" class="px-6 py-3">
                Phone Number
              </th>
              <th scope="col" class="px-6 py-3">
                Email
              </th>
              <th scope="col" class="px-6 py-3">
                Delete
              </th>
            </tr>
            </thead>
            <tbody v-for="organizers in organizersStore.getOrganizers" :key="organizers.id">
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
              <td class="p-4">
                <img :src="'http://127.0.0.1:8000/storage/' + organizers.picture" class="w-32 md:w-64 max-w-full max-h-full" alt="Organizer's Profile Picture">
                <form @submit.prevent class="inline-block">
                  <input type="hidden" v-model="organizers.id">
                  <input type="file" accept="image/*" @change="onFileChange" class="inline-block">
                </form>
              </td>

              <td>
                <input type="text" v-model="organizers.name" placeholder="First Name" class="inline-block">
              </td>
              <td>
                <input type="text" v-model="organizers.phone_number" placeholder="Last Name" class="inline-block">
              </td>
              <td>
                <input type="text" v-model="organizers.email" placeholder="Short Description" class="inline-block">
              </td>
              <td>
                <button class="font-medium text-green-600 dark:text-green-500 hover:underline inline-block" type="submit">Update</button>
              </td>
              <td>
                <form @submit.prevent class="inline-block">
                  <button class="font-medium text-red-600 dark:text-red-500 hover:underline inline-block" type="submit" @click="organizersStore.destroyOrganizers(organizers.id)">DELETE</button>
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

  </div>



</template>
<script>
import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'
import AdminNavComponent from "@/components/AdminNavComponent.vue";
import SuccessAlertComponent from "@/components/alerts/SuccessAlertComponent.vue";
import ErrorAlertComponent from "@/components/alerts/ErrorAlertComponent.vue";
import {UseOrganizersStore} from "@/stores/OrganizersStore.js";


export default {
  components: {ErrorAlertComponent, SuccessAlertComponent, AdminNavComponent},
  data(){
    return {
      name: '',
      phone_number: '',
      email: '',
      file: null,
      imageUrl: "",
      stages:[],
      errors:[],
      organizersStore: UseOrganizersStore(),
    };
  },
  created(){
    this.organizersStore.fetchOrganizers();
  },
  mounted() {
    initFlowbite();
  }
  ,
  methods:{
    submitForm() {
      this.organizersStore.insertOrganizers(this.name, this.phone_number, this.email,this.file);
      this.name = '';
      this.phone_number = '';
      this.email = '';
      this.file = null;
      this.imageUrl = "";
      this.organizersStore.error_name = '';
      this.organizersStore.error_email = '';
      this.organizersStore.error_phone_number = '';
      this.organizersStore.error_image= '';
    },
    createImage(file) {
      const reader = new FileReader();

      reader.onload = e => {
        this.imageUrl = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    onFileChange(event) {
      const file = event.target.files[0];
      if (!file) {
        return;
      }
      console.log("File:", file);
      this.file = file;
      this.createImage(file);
    }
  }
}
</script>
