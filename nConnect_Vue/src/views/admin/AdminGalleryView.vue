<style scoped>
@import '/src/assets/main.css';
</style>
<template>
  <AdminNavComponent/>

  <div class="p-4 sm:ml-64 ">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">


      <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

        <v-sheet class="max-w-sm">
          <v-form @submit.prevent>
            <v-file-input v-model="image" label="Image" accept="image/*"></v-file-input>
            <div v-if="galleryStore.error_image">
              <span class="text-sm text-red-400">
                {{galleryStore.error_image}}
              </span>
            </div>
            <v-text-field v-model="year" label="Year" type="number"></v-text-field>
            <div v-if="galleryStore.error_year">
              <span class="text-sm text-red-400">
                {{galleryStore.error_year}}
              </span>
            </div>
            <v-btn class="mt-2" type="submit" @click="submitForm()" block>Save</v-btn>
          </v-form>
        </v-sheet>
      </div>
    </div>
  </div>

</template>
<script>
import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'
import {UseGalleryStore} from "@/stores/GalleryStore.js";
import AdminNavComponent from "@/components/AdminNavComponent.vue";
import SuccessAlertComponent from "@/components/alerts/SuccessAlertComponent.vue";
import ErrorAlertComponent from "@/components/alerts/ErrorAlertComponent.vue";
import {useStageStore} from "@/stores/StageStore.js";


export default {
  components: {ErrorAlertComponent, SuccessAlertComponent, AdminNavComponent},
  mounted() {
    initFlowbite();
  },
  data() {
    return {
      image: '',
      year: '',
      gallery: [],
      errors: [],
      galleryStore: UseGalleryStore(),
    };
  },
  created() {
    this.galleryStore.fetchGallery();
  },
  methods: {
    submitForm() {
      this.galleryStore.insertGallery(this.image, this.year);
      this.galleryStore.error_image = '';
      this.galleryStore.error_year = '';
      this.image = '';
      this.year = '';
    },
  },
}
</script>
