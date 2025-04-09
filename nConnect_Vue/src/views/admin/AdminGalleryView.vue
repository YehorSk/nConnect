<style scoped>
@import '/src/assets/main.css';
</style>
<template>
  <AdminNavComponent/>

  <div class="p-4 sm:ml-64 ">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">


      <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

        <v-sheet class="max-w-sm">
          <v-form fast-fail @submit.prevent>
            <v-file-input
                v-model="addFile"
                label="Image"
                color="orange"
                :prepend-icon="null"
                accept="image/*"
                @change="onFileChange($event, 'add')"
            ></v-file-input>
            <div v-if="galleryStore.error_image">
              <span class="text-sm text-red-400">
                {{galleryStore.error_image}}
              </span>
            </div>
            <v-text-field
                v-model="year"
                label="Year"
                type="number"
                color="orange"
            ></v-text-field>
            <div v-if="galleryStore.error_year">
              <span class="text-sm text-red-400">
                {{galleryStore.error_year}}
              </span>
            </div>
            <v-img v-if="addImageUrl" :src="addImageUrl" />
            <v-btn class="mt-2" type="submit" @click="submitForm()" block>Save</v-btn>
          </v-form>
        </v-sheet>
      </div>
      <br>
      <div class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th scope="col" class="px-6 py-3">Image</th>
            <th scope="col" class="px-6 py-3">Year</th>
            <th scope="col" class="px-6 py-3">Update</th>
            <th scope="col" class="px-6 py-3">Delete</th>
          </tr>
          </thead>
          <tbody v-for="gallery in galleryStore.getGallery.data" :key="gallery.id">
          <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <td class="px-6 py-4">
              <img :src="'https://api.nconnect.mojawebka.eu/nConnect-Laravel/public/storage/' + gallery.image" class="w-32 md:w-64 max-w-full max-h-full" alt="Gallery image">
              <form @submit.prevent class="inline-block mt-2">
                <input type="hidden" v-model="gallery.id">
                <input type="file" accept="image/*" @change="onFileChange($event,'update')" class="inline-block">
              </form>
            </td>
            <td class="px-6 py-4">
              <input type="number" v-model="gallery.year" placeholder="year" >
            </td>
            <td class="px-6 py-4">
              <v-btn @click="updateForm(gallery)"
                     color="green-lighten-2"
                     text="Update"
              ></v-btn>
            </td>
            <td class="px-6 py-4">
              <form @submit.prevent class="inline-block">
                <v-btn @click="galleryStore.destroyGallery(gallery.id)"
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
    <div v-if="galleryStore.success" id="alert-3" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
      <SuccessAlertComponent :message="galleryStore.success"/>
    </div>
    <div v-if="galleryStore.errors" id="alert-2" class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
      <ErrorAlertComponent :message="galleryStore.errors"/>
    </div>
    <div class="text-center">
      <v-pagination
          v-model="page"
          :length="galleryStore.getGallery.last_page"
          rounded="circle"
      ></v-pagination>
    </div>
  </div>


</template>
<script>
import { initFlowbite } from 'flowbite'
import {UseGalleryStore} from "@/stores/GalleryStore.js";
import AdminNavComponent from "@/components/AdminNavComponent.vue";
import SuccessAlertComponent from "@/components/alerts/SuccessAlertComponent.vue";
import ErrorAlertComponent from "@/components/alerts/ErrorAlertComponent.vue";
import {watch} from "vue";


export default {
  components: {ErrorAlertComponent, SuccessAlertComponent, AdminNavComponent},
  mounted() {
    initFlowbite();
    watch(() => this.page, (newValue, oldValue) => {
      if (newValue) {
        this.galleryStore.fetchGallery(this.page)
      }
    })

  },
  data() {
    return {
      galleryStore: UseGalleryStore(),
      addFile: null,
      updateFile: null,
      addImageUrl: "",
      updateImageUrl:"",
      year: '',
      gallery: [],
      errors: [],
      page: 1,
    };
  },
  created() {
    this.galleryStore.fetchGallery();
    this.galleryStore.success = '';
  },
  methods: {
    submitForm() {
      this.galleryStore.insertGallery(this.addFile, this.year);
      this.galleryStore.error_image = '';
      this.galleryStore.error_year = '';
      this.year = '';
      this.addFile = null;
      this.addImageUrl = "";
    },
    updateForm(gallery){
      console.log("File", this.file);
      this.galleryStore.updateGallery(gallery, this.updateFile);
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
    onFileChange(event,form) {
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
    }

  },
}
</script>
