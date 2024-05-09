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
                v-model="first_name"
                label="First Name"
            ></v-text-field>
            <div v-if="speakersStore.error_first_name">
              <span class="text-sm text-red-400">
                {{speakersStore.error_first_name}}
              </span>
            </div>
            <v-text-field
                v-model="last_name"
                label="Last Name	"
            ></v-text-field>
            <div v-if="speakersStore.error_name">
              <span class="text-sm text-red-400">
                {{speakersStore.error_last_name}}
              </span>
            </div>
            <v-text-field
                v-model="short_desc"
                label="Short Description"
            ></v-text-field>
            <div v-if="speakersStore.error_name">
              <span class="text-sm text-red-400">
                {{speakersStore.error_short_desc}}
              </span>
            </div>
            <v-text-field
                v-model="long_desc	"
                label="Long Description"
            ></v-text-field>
            <div v-if="speakersStore.error_name">
              <span class="text-sm text-red-400">
                {{speakersStore.error_long_desc}}
              </span>
            </div>
            <v-text-field
                v-model="company"
                label="Company"
            ></v-text-field>
            <div v-if="speakersStore.error_name">
              <span class="text-sm text-red-400">
                {{speakersStore.error_company}}
              </span>
            </div>
            <v-text-field
                v-model="instagram"
                label="Instagram"
            ></v-text-field>
            <div v-if="speakersStore.error_link">
              <span class="text-sm text-red-400">
                {{speakersStore.error_link}}
              </span>
            </div>
            <v-text-field
                v-model="linkedIn"
                label="LinkedIn"
            ></v-text-field>
            <div v-if="speakersStore.error_link">
              <span class="text-sm text-red-400">
                {{speakersStore.error_link}}
              </span>
            </div>
            <v-text-field
                v-model="facebook"
                label="Facebook"
            ></v-text-field>
            <div v-if="speakersStore.error_link">
              <span class="text-sm text-red-400">
                {{speakersStore.error_link}}
              </span>
            </div>
            <v-text-field
                v-model="twitter"
                label="Twitter"
            ></v-text-field>
            <div v-if="speakersStore.error_link">
              <span class="text-sm text-red-400">
                {{speakersStore.error_link}}
              </span>
            </div>
            <v-file-input
                v-model="file"
                accept="image/png, image/jpeg, image/bmp"
                :prepend-icon="null"
                color="black"
                @change="onFileChange"
                label="Choose Image">
            </v-file-input>
            <div v-if="speakersStore.error_image">
              <span class="text-sm text-red-400">
                {{speakersStore.error_image}}
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
                Image
              </th>
              <th scope="col" class="px-6 py-3">
                First Name
              </th>
              <th scope="col" class="px-6 py-3">
                Last Name
              </th>
              <th scope="col" class="px-6 py-3">
                Short Description
              </th>
              <th scope="col" class="px-6 py-3">
                Long Description
              </th>
              <th scope="col" class="px-6 py-3">
                Company
              </th>
              <th scope="col" class="px-6 py-3">
                Instagram
              </th>
              <th scope="col" class="px-6 py-3">
                LinkedIn
              </th>
              <th scope="col" class="px-6 py-3">
                Facebook
              </th>
              <th scope="col" class="px-6 py-3">
                Twitter
              </th>
              <th scope="col" class="px-6 py-3">
                Delete
              </th>
            </tr>
            </thead>
            <tbody v-for="speakers in speakersStore.getSpeakers" :key="speakers.id">
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
              <td class="p-4">
                <img :src="'http://127.0.0.1:8000/storage/' + speakers.picture" class="w-32 md:w-64 max-w-full max-h-full" alt="Apple Watch">
              </td>
              <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                {{speakers.first_name}}
              </td>
              <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                {{speakers.last_name}}
              </td>
              <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                {{speakers.short_desc}}
              </td>
              <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                {{speakers.long_desc}}
              </td>
              <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                {{speakers.company}}
              </td>
              <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                {{speakers.instagram}}
              </td>
              <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                {{speakers.linkedIn}}
              </td>
              <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                {{speakers.facebook}}
              </td>
              <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                {{speakers.twitter}}
              </td>
              <td>
                <form @submit.prevent class="inline-block">
                  <button class="font-medium text-red-600 dark:text-red-500 hover:underline inline-block" type="submit" @click="speakersStore.destroySpeakers(speakers.id)">DELETE</button>
                </form>
              </td>
            </tr>
            </tbody>
          </table>

        </div>
      </div>
    </div>

    <div v-if="speakersStore.success" id="alert-3" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
      <SuccessAlertComponent :message="speakersStore.success"/>
    </div>

  </div>



</template>
<script>
import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'
import AdminNavComponent from "@/components/AdminNavComponent.vue";
import SuccessAlertComponent from "@/components/alerts/SuccessAlertComponent.vue";
import ErrorAlertComponent from "@/components/alerts/ErrorAlertComponent.vue";
import {useSpeakersStore} from "@/stores/SpeakersStore.js";


export default {
  components: {ErrorAlertComponent, SuccessAlertComponent, AdminNavComponent},
  data(){
    return {
      first_name: '',
      last_name: '',
      short_desc: '',
      long_desc: '',
      company: '',
      file: null,
      imageUrl: "",
      instagram: '',
      linkedIn: '',
      facebook: '',
      twitter: '',
      stages:[],
      errors:[],
      speakersStore: useSpeakersStore(),
    };
  },
  created(){
    this.speakersStore.fetchSpeakers();
  },
  mounted() {
    initFlowbite();
  }
  ,
  methods:{
    submitForm() {
      this.speakersStore.insertSpeakers(this.first_name,this.last_name, this.short_desc, this.long_desc, this.company, this.instagram, this.linkedIn, this.facebook, this.twitter, this.file);
      this.first_name = '';
      this.last_name = '';
      this.short_desc = '';
      this.long_desc = '';
      this.company = '';
      this.instagram = '';
      this.linkedIn = '';
      this.facebook = '';
      this.twitter = '';
      this.file = null;
      this.imageUrl = "";
      this.speakersStore.error_first_name = '';
      this.speakersStore.error_last_name = '';
      this.speakersStore.error_short_desc = '';
      this.speakersStore.error_long_desc = '';
      this.speakersStore.error_company = '';
      this.speakersStore.error_link = '';
      this.speakersStore.error_image = '';
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
      this.createImage(file);
    }
  }
}
</script>
