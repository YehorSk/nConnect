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
            <v-select :item-props="itemProps" v-model="gallery" :items="galleryStore.getAvailableGallery" label="Available Gallery"></v-select>
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
                Year
              </th>
              <th scope="col" class="px-6 py-3">
                Delete
              </th>
            </tr>
            </thead>
            <tbody v-for="gallery in galleryStore.getCurrentGallery" :key="gallery.id">
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
              <td class="p-4">
                <img :src="'http://127.0.0.1:8000/storage/' + gallery.image" class="w-32 md:w-64 max-w-full max-h-full" alt="Apple Watch">
              </td>
              <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                {{gallery.year}}
              </td>
              <td>
                <form @submit.prevent class="inline-block">
                  <button class="font-medium text-red-600 dark:text-red-500 hover:underline inline-block" type="submit" @click="galleryStore.deleteGalleryFromConference(gallery.id)">DELETE</button>
                </form>
              </td>
            </tr>
            </tbody>
          </table>

        </div>
      </div>
    </div>

    <div v-if="galleryStore.success" id="alert-3" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
      <SuccessAlertComponent :message="galleryStore.success"/>
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
import {UseGalleryStore} from "@/stores/GalleryStore.js";


export default {
  components: {ErrorAlertComponent, SuccessAlertComponent, AdminNavComponent},
  data(){
    return {
      image: '',
      file: null,
      imageUrl: "",
      year: '',
      stages:[],
      errors:[],
      gallery:[],
      galleryStore: UseGalleryStore(),
    };
  },
  created(){
    this.galleryStore.fetchGallery();
    this.galleryStore.fetchCurrentConferenceGallery();
    this.galleryStore.fetchAvailableGallery();
  },
  mounted() {
    initFlowbite();
  }
  ,
  methods:{
    submitForm() {
      this.galleryStore.addGalleryToConference(this.gallery.id);
      this.gallery=[];
    },
    itemProps (item) {
      return {
        title: item.image,
        subtitle: item.year,
      }
    },
  }
}
</script>
