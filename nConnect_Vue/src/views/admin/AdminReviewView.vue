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
            <v-file-input v-model="addPhoto" label="Choose Photo" :prepend-icon="null" accept="image/*" @change="onFileChange($event, 'add')"></v-file-input>
            <div v-if="reviewStore.error_photo">
      <span class="text-sm text-red-400">
        {{reviewStore.error_photo}}
      </span>
            </div>
            <v-img :src="addImageUrl" />
            <v-btn class="mt-2" type="submit" @click="submitForm()" block>Save</v-btn>
          </v-form>
        </v-sheet>

      </div>
      <br>
      <div class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">

          <div class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <div v-for="reviews in reviewStore.getReviews" :key="reviews.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 items-center">
              <div>
                <img :src="'http://127.0.0.1:8000/storage/' + reviews.image" class="inline-block mr-2" style="max-width: 100px;" alt="Review Image">
                <form @submit.prevent class="inline-block">
                  <input type="hidden" v-model="reviews.id">
                  <input type="text" v-model="reviews.name" placeholder="Name" class="inline-block mr-2">
                  <input type="text" v-model="reviews.text" placeholder="Date" class="inline-block mr-2">
                  <input type="file" accept="image/*" @change="onFileChange($event, 'update')" class="inline-block mr-2">
                  <button class="font-medium text-green-600 dark:text-green-500 hover:underline inline-block mr-2" @click="updateForm(reviews)" type="submit">Update</button>
                </form>
                <form @submit.prevent class="inline-block">
                  <button class="font-medium text-red-600 dark:text-red-500 hover:underline inline-block" type="submit" @click="reviewStore.destroyReviews(reviews.id)">DELETE</button>
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
  },
  methods: {
    submitForm() {
      this.reviewStore.insertReviews(this.name, this.text, this.addPhoto);
      this.reviewStore.error_name = '';
      this.reviewStore.error_text = '';
      this.reviewStore.error_photo = '';
      this.name = '';
      this.text = '';
      this.addFile = null;
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
