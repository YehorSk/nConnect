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
            <v-text-field v-model="name" label="Name" type="text"></v-text-field>
            <div v-if="reviewStore.error_name">
      <span class="text-sm text-red-400">
        {{reviewStore.error_name}}
      </span>
            </div>
            <v-text-field v-model="text" label="Text" type="text"></v-text-field>
            <div v-if="reviewStore.error_text">
      <span class="text-sm text-red-400">
        {{reviewStore.error_text}}
      </span>
            </div>
            <v-file-input v-model="photo" label="Choose Photo" :prepend-icon="null" accept="image/*" @change="onFileChange"></v-file-input>
            <div v-if="reviewStore.error_photo">
      <span class="text-sm text-red-400">
        {{reviewStore.error_photo}}
      </span>
            </div>
            <v-img :src="imageUrl" />
            <v-btn class="mt-2" type="submit" @click="submitForm()" block>Save</v-btn>
          </v-form>
        </v-sheet>

      </div>
      <br>
      <div class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">

          <div class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <div v-for="review in reviewStore.getReviews" :key="review.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 items-center">
              <div>
                <form @submit.prevent class="inline-block">
                  <input type="hidden" v-model="review.id">
                  <input type="text" v-model="review.name" placeholder="Name" class="inline-block mr-2">
                  <input type="text" v-model="review.text" placeholder="Date" class="inline-block mr-2">
                  <input type="file" @change="onFileChange($event, review)" class="inline-block mr-2"> <!-- File input for photo -->
                  <img :src="'http://127.0.0.1:8000/storage/' + review.photo" class="inline-block mr-2" style="max-width: 100px;">
                  <button class="font-medium text-green-600 dark:text-green-500 hover:underline inline-block mr-2" @click="updateForm(review)" type="submit">Update</button>
                </form>
                <form @submit.prevent class="inline-block">
                  <button class="font-medium text-red-600 dark:text-red-500 hover:underline inline-block" type="submit" @click="reviewStore.destroyReviews(review.id)">DELETE</button>
                </form>
              </div>
            </div>
          </div>
      </div>

    </div>
    <div v-if="reviewStore.success" id="alert-3" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
      <SuccessAlertComponent :message="reviewStore.success"/>
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

      name: '',
      text: '',
      photo: '',
      file: null,
      imageUrl: "",
      reviews: [],
      errors: [],
      reviewStore: UseReviewStore(),
    };
  },
  created() {
    this.reviewStore.fetchReviews();
  },
  methods: {
    submitForm() {
      this.reviewStore.insertReviews(this.name, this.text, this.photo);
      this.reviewStore.error_name = '';
      this.reviewStore.error_text = '';
      this.reviewStore.error_photo = '';
      this.name = '';
      this.text = '';
      this.photo = '';
      this.file = null;
      this.imageUrl = "";
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
    },
    updateForm(review){
      this.reviewStore.updateReview(review);
      this.reviewStore.error_name = '';
      this.reviewStore.error_text = '';
      this.reviewStore.error_photo = '';
    }


  },
}
</script>
