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
            <div v-if="sponsorsStore.error_name">
              <span class="text-sm text-red-400">
                {{sponsorsStore.error_name}}
              </span>
            </div>
            <v-text-field
                v-model="link"
                label="Link"
            ></v-text-field>
            <div v-if="sponsorsStore.error_link">
              <span class="text-sm text-red-400">
                {{sponsorsStore.error_link}}
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
            <div v-if="sponsorsStore.error_image">
              <span class="text-sm text-red-400">
                {{sponsorsStore.error_image}}
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
                Name
              </th>
              <th scope="col" class="px-6 py-3">
                Link
              </th>
              <th scope="col" class="px-6 py-3">
                Delete
              </th>
            </tr>
            </thead>
            <tbody v-for="sponsor in sponsorsStore.getSponsors" :key="sponsor.id">
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
              <td class="p-4">
                <img :src="'http://127.0.0.1:8000/storage/' + sponsor.image" class="w-32 md:w-64 max-w-full max-h-full" alt="Apple Watch">
              </td>
              <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                {{sponsor.name}}
              </td>
              <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                {{sponsor.link}}
              </td>
              <td>
                <form @submit.prevent class="inline-block">
                  <button class="font-medium text-red-600 dark:text-red-500 hover:underline inline-block" type="submit" @click="sponsorsStore.destroySponsor(sponsor.id)">DELETE</button>
                </form>
              </td>
            </tr>
            </tbody>
          </table>

        </div>
      </div>
    </div>

    <div v-if="sponsorsStore.success" id="alert-3" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
      <SuccessAlertComponent :message="sponsorsStore.success"/>
    </div>

  </div>



</template>
<script>
import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'
import {useStageStore} from "@/stores/StageStore.js";
import AdminNavComponent from "@/components/AdminNavComponent.vue";
import SuccessAlertComponent from "@/components/alerts/SuccessAlertComponent.vue";
import ErrorAlertComponent from "@/components/alerts/ErrorAlertComponent.vue";
import {useSponsorsStore} from "@/stores/SponsorsStore.js";


export default {
  components: {ErrorAlertComponent, SuccessAlertComponent, AdminNavComponent},
  data(){
    return {
      name: '',
      file: null,
      imageUrl: "",
      link: '',
      stages:[],
      errors:[],
      sponsorsStore: useSponsorsStore(),
    };
  },
  created(){
    this.sponsorsStore.fetchSponsors();
  },
  mounted() {
    initFlowbite();
  }
  ,
  methods:{
    submitForm() {
      this.sponsorsStore.insertSponsor(this.name,this.link,this.file);
      this.name = '';
      this.link = '';
      this.file = null;
      this.imageUrl = "";
      this.sponsorsStore.error_name = '';
      this.sponsorsStore.error_link = '';
      this.sponsorsStore.error_image = '';
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
