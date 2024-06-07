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
            <v-text-field
                v-model="name"
                label="Name"
                color="orange"
            ></v-text-field>
            <div v-if="sponsorsStore.error_name">
              <span class="text-sm text-red-400">
                {{sponsorsStore.error_name}}
              </span>
            </div>
            <v-text-field
                v-model="link"
                label="Link"
                color="orange"
            ></v-text-field>
            <div v-if="sponsorsStore.error_link">
              <span class="text-sm text-red-400">
                {{sponsorsStore.error_link}}
              </span>
            </div>
            <v-file-input
                v-model="addFile"
                accept="image/png, image/jpeg, image/bmp"
                :prepend-icon="null"
                color="orange"
                @change="onFileChange($event, 'add')"
                label="Choose Image">
            </v-file-input>
            <div v-if="sponsorsStore.error_image">
              <span class="text-sm text-red-400">
                {{sponsorsStore.error_image}}
              </span>
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
              <th scope="col" class="px-6 py-3">Link</th>
              <th scope="col" class="px-6 py-3">Update</th>
              <th scope="col" class="px-6 py-3">Delete</th>
            </tr>
            </thead>
            <tbody v-for="sponsors in sponsorsStore.getSponsors" :key="sponsors.id">
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
              <td class="px-6 py-4">
                <img :src="'http://127.0.0.1:8000/storage/' + sponsors.image" class="w-32 md:w-64 max-w-full max-h-full" alt="Sponsor Image">
                <form @submit.prevent class="inline-block mt-2">
                  <input type="hidden" v-model="sponsors.id">
                  <input type="file" accept="image/*" @change="onFileChange($event,'update')" class="inline-block">
                </form>
              </td>
              <td class="px-6 py-4">
                <input type="text" v-model="sponsors.name" placeholder="name" class="inline-block w-full">
              </td>
              <td class="px-6 py-4">
                <input type="text" v-model="sponsors.link" placeholder="link" class="inline-block w-full">
              </td>
              <td class="px-6 py-4">
                <v-btn @click="updateForm(sponsors)"
                       color="green-lighten-2"
                       text="Update"
                ></v-btn>
              </td>
              <td class="px-6 py-4">
                <form @submit.prevent class="inline-block">
                  <v-btn @click="sponsorsStore.destroySponsor(sponsors.id)"
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

    <div v-if="sponsorsStore.success" id="alert-3" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
      <SuccessAlertComponent :message="sponsorsStore.success"/>
    </div>
    <div v-if="sponsorsStore.errors" id="alert-2" class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
      <ErrorAlertComponent :message="sponsorsStore.errors"/>
    </div>

  </div>

</template>

<script>
import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'
import AdminNavComponent from "@/components/AdminNavComponent.vue";
import SuccessAlertComponent from "@/components/alerts/SuccessAlertComponent.vue";
import ErrorAlertComponent from "@/components/alerts/ErrorAlertComponent.vue";
import { useSponsorsStore } from "@/stores/SponsorsStore.js";


export default {
  components: { ErrorAlertComponent, SuccessAlertComponent, AdminNavComponent },
  data() {
    return {
      addFile: null,
      updateFile: null,
      addImageUrl: "",
      updateImageUrl: "",
      name: '',
      link: '',
      sponsors: [],
      errors: [],
      sponsorsStore: useSponsorsStore(),
    };
  },
  created() {
    this.sponsorsStore.fetchSponsors();
    this.sponsorsStore.success = '';
  },
  mounted() {
    initFlowbite();
  },
  methods: {
    submitForm() {
      this.sponsorsStore.insertSponsor(this.name, this.link, this.addFile);
      this.name = '';
      this.link = '';
      this.addFile = null;
      this.addImageUrl = "";
      this.sponsorsStore.error_name = '';
      this.sponsorsStore.error_link = '';
      this.sponsorsStore.error_image = '';
    },
    updateForm(sponsors) {
      this.sponsorsStore.updateSponsors(sponsors, this.updateFile);
      this.updateFile = null;
      this.updateImageUrl = "";
    },
    createImage(file, form) {
      if (!(file instanceof Blob)) {
        console.error('blob error');
        return;
      }
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
    onFileChange(event, form) {
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
  }
}
</script>
