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
            <div v-if="reviewStore.error_name">
              <span class="text-sm text-red-400">{{reviewStore.error_name}}</span>
            </div>
            <v-text-field
                v-model="text"
                label="Text"
                color="orange"
            ></v-text-field>
            <div v-if="reviewStore.error_text">
              <span class="text-sm text-red-400">{{reviewStore.error_text}}</span>
            </div>
            <v-file-input
                v-model="addPhoto"
                accept="image/png, image/jpeg, image/bmp"
                :prepend-icon="null"
                color="orange"
                @change="onFileChange($event, 'add')"
                label="Choose Photo"
            ></v-file-input>
            <div v-if="reviewStore.error_photo">
              <span class="text-sm text-red-400">{{reviewStore.error_photo}}</span>
            </div>
            <v-img v-if="addImageUrl" :src="addImageUrl" />
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
                {{review.name}}
              </td>
              <td class="px-6 py-4">
                <v-btn class="font-medium text-green-600 dark:text-green-500 hover:underline inline-block" @click="dialog = true,editReviews(review)">
                  Show/Update
                </v-btn>
              </td>
              <td class="px-6 py-4">
                <form @submit.prevent class="inline-block">
                  <v-btn @click="reviewStore.destroyReviews(review.id)"
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
    <div v-if="reviewStore.success" id="alert-3" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
      <SuccessAlertComponent :message="reviewStore.success"/>
    </div>
    <div v-if="reviewStore.errors" id="alert-2" class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
      <ErrorAlertComponent :message="reviewStore.errors"/>
    </div>
    <v-dialog v-model="dialog" width="auto" persistent>
      <v-card min-width="600" prepend-icon="mdi-update" title="Update Review">
        <v-card-text>
          <img :src="'http://127.0.0.1:8000/storage/' + edit_reviews.image" class="w-16 md:w-32 max-w-full max-h-full" alt="Review picture">
          <input type="file" accept="image/*" @change="onFileChange($event, 'update')" class="mb-4">
          <v-text-field
              v-model="edit_reviews.name"
              label="Name"
              color="orange"
          ></v-text-field>
          <v-textarea
              v-model="edit_reviews.text"
              label="Text"
              color="orange"
              row-height="25"
              rows="4"
              auto-grow
          ></v-textarea>
        </v-card-text>
        <template v-slot:actions>
          <v-btn class="ms-auto" text="Close" @click="dialog = false, reviewStore.refreshReviews()"></v-btn>
          <v-btn class="font-medium text-green-600 dark:text-green-500 hover:underline" text="Update" @click="dialog = false,updateForm(edit_reviews)"></v-btn>
        </template>
      </v-card>
    </v-dialog>
    <v-dialog v-model="error_dialog" width="auto" persistent>
      <v-card min-width="600" prepend-icon="mdi-update" title="We couldn't perform the update. Please check the data you've entered and try again.">
        <v-card-text>
          <ul>
            <li v-for="(errors, fieldName) in reviewStore.errors_update" :key="fieldName">
              <ul>
                <li v-for="error in errors" :key="error">{{ error }}</li>
              </ul>
            </li>
          </ul>
        </v-card-text>
        <template v-slot:actions>
          <v-btn class="ms-auto" text="Close" @click="closeErrorDialog"></v-btn>
        </template>
      </v-card>
    </v-dialog>
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
      edit_reviews: [],
      dialog: false,
      error_dialog: false,
      errors: [],
      reviewStore: UseReviewStore(),
    };
  },
  created() {
    this.reviewStore.fetchReviews();
    this.reviewStore.success = '';
  },
  methods: {
    editReviews(reviews){
      this.edit_reviews = reviews;
    },
    submitForm() {
      this.reviewStore.insertReviews(this.name, this.text, this.addPhoto);
      this.reviewStore.error_name = '';
      this.reviewStore.error_text = '';
      this.reviewStore.error_photo = '';
      this.name = '';
      this.text = '';
      this.addPhoto = null;
      this.addImageUrl = "";
      this.reviewStore.refreshReviews();
    },
    updateForm(reviews){
      console.log("File", this.file);
      this.reviewStore.updateReview(reviews, this.updatePhoto);
      if (this.reviewStore.errors_update.length > 0){
        this.callErrorDialog();
      }
    },
    createImage(file,form) {
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
    callErrorDialog() {
      this.error_dialog = true;
    },
    closeErrorDialog() {
      this.error_dialog = false;
      this.reviewStore.errors_update = [];
      this.reviewStore.fetchReviews();
    }
  },
}
</script>
