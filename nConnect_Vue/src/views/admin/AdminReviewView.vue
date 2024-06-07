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
            <v-text-field v-model="name" label="Name"></v-text-field>
            <div v-if="reviewStore.error_name">
              <span class="text-sm text-red-400">{{reviewStore.error_name}}</span>
            </div>
            <v-text-field v-model="text" label="Text"></v-text-field>
            <div v-if="reviewStore.error_text">
              <span class="text-sm text-red-400">{{reviewStore.error_text}}</span>
            </div>
            <v-file-input v-model="addPhoto" accept="image/png, image/jpeg, image/bmp" :prepend-icon="null" color="black" @change="onFileChange($event, 'add')" label="Choose Photo"></v-file-input>
            <div v-if="reviewStore.error_photo">
              <span class="text-sm text-red-400">{{reviewStore.error_photo}}</span>
            </div>
            <v-img :src="addImageUrl" />
            <v-btn class="mt-2" type="submit" @click="submitForm()" block>Save</v-btn>
          </v-form>
        </v-sheet>
        <br>
        <div class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
          <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
              <th scope="col" class="px-6 py-3">Image</th>
              <th scope="col" class="px-6 py-3">Name</th>
              <th scope="col" class="px-6 py-3">Text</th>
              <th scope="col" class="px-6 py-3">Update</th>
              <th scope="col" class="px-6 py-3">Delete</th>
            </tr>
            </thead>
            <tbody v-for="review in reviewStore.getReviews" :key="review.id">
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
              <td class="px-6 py-4">
                <img :src="'http://127.0.0.1:8000/storage/' + review.image" class="w-32 md:w-64 max-w-full max-h-full" alt="Review Image">
                <form @submit.prevent class="inline-block mt-2">
                  <input type="hidden" v-model="review.id">
                  <input type="file" accept="image/*" @change="onFileChange($event, 'update')" class="inline-block">
                </form>
              </td>
              <td class="px-6 py-4">
                <input type="text" v-model="review.name" placeholder="Name" class="inline-block w-full">
              </td>
              <td class="px-6 py-4">
                <input type="text" v-model="review.text" placeholder="Text" class="inline-block w-full">
              </td>
              <td class="px-6 py-4">
                <button class="font-medium text-green-600 dark:text-green-500 hover:underline inline-block" @click="updateForm(review)" type="submit">Update</button>
              </td>
              <td class="px-6 py-4">
                <form @submit.prevent class="inline-block">
                  <button class="font-medium text-red-600 dark:text-red-500 hover:underline inline-block" type="submit" @click="reviewStore.destroyReviews(review.id)">DELETE</button>
                </form>
              </td>
            </tr>
            </tbody>
          </table>
        </div>

      </div>
    </div>
    <div v-if="reviewStore.success" id="alert-3" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
      <SuccessAlertComponent :message="reviewStore.success"/>
    </div>
    <div v-if="reviewStore.errors" id="alert-2" class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
      <ErrorAlertComponent :message="reviewStore.errors"/>
    </div>
  </div>
</template>
<script>
import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'
import {UseReviewStore} from "@/stores/ReviewStore.js";
import AdminNavComponent from "@/components/AdminNavComponent.vue";
import SuccessAlertComponent from "@/components/alerts/SuccessAlertComponent.vue";
import ErrorAlertComponent from "@/components/alerts/ErrorAlertComponent.vue";


export default {
  components: {ErrorAlertComponent, SuccessAlertComponent, AdminNavComponent},
  mounted() {
    initFlowbite();
  },
  data() {
    return {

      addPhoto: null,
      updatePhoto: null,
      addImageUrl: "",
      updateImageUrl: "",
      name: '',
      text: '',
      reviews: [],
      errors: [],
      reviewStore: UseReviewStore(),
    };
  },
  created() {
    this.reviewStore.fetchReviews();
    this.reviewStore.success = '';
  },
  methods: {
    submitForm() {
      this.reviewStore.insertReviews(this.name, this.text, this.addPhoto);
      this.reviewStore.error_name = '';
      this.reviewStore.error_text = '';
      this.reviewStore.error_photo = '';
      this.name = '';
      this.text = '';
      this.addPhoto = null;
      this.addImageUrl = "";
    },
    updateForm(reviews){
      console.log("File", this.file);
      this.reviewStore.updateReview(reviews, this.updatePhoto);
    },
    createImage(file,form) {
      if (!(file instanceof Blob)) {
        console.error('blob error');
        return;
      }
      const reader = new FileReader();

      reader.onload = e => {
        if (form === 'update') {
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
        this.updatePhoto = file;
      } else {
        this.addPhoto = file;
      }
      this.createImage(file,form);
    },


  },
}
</script>
