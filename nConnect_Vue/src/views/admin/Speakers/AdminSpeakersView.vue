<style scoped>
@import '/src/assets/main.css';
</style>
<template>
  <AdminNavComponent/>

  <div class="p-4 sm:ml-64 ">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">


      <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

        <v-sheet class="max-w-full">
          <v-form fast-fail @submit.prevent>
            <div class="grid grid-cols-2 gap-4">
              <div class="col-span-1">
                <v-text-field
                    v-model="first_name"
                    label="First Name"
                    color="orange"
                ></v-text-field>
                <div v-if="speakersStore.error_first_name">
          <span class="text-sm text-red-400">
            {{speakersStore.error_first_name}}
          </span>
                </div>
                <v-text-field
                    v-model="last_name"
                    label="Last Name"
                    color="orange"
                ></v-text-field>
                <div v-if="speakersStore.error_last_name">
          <span class="text-sm text-red-400">
            {{speakersStore.error_last_name}}
          </span>
                </div>
                <v-text-field
                    v-model="short_desc"
                    label="Short Description"
                    color="orange"
                ></v-text-field>
                <div v-if="speakersStore.error_short_desc">
          <span class="text-sm text-red-400">
            {{speakersStore.error_short_desc}}
          </span>
                </div>
                <v-textarea
                    v-model="long_desc"
                    label="Long Description"
                    color="orange"
                    outlined
                    rows="5"
                ></v-textarea>
                <div v-if="speakersStore.error_long_desc">
          <span class="text-sm text-red-400">
            {{speakersStore.error_long_desc}}
          </span>
                </div>
                <v-text-field
                    v-model="company"
                    label="Company"
                    color="orange"
                ></v-text-field>
                <div v-if="speakersStore.error_company">
          <span class="text-sm text-red-400">
            {{speakersStore.error_company}}
          </span>
                </div>
              </div>
              <div class="col-span-1">
                <v-text-field
                    v-model="instagram"
                    label="Instagram"
                    color="orange"
                ></v-text-field>
                <div v-if="speakersStore.error_instagram">
          <span class="text-sm text-red-400">
            {{speakersStore.error_instagram}}
          </span>
                </div>
                <v-text-field
                    v-model="linkedIn"
                    label="LinkedIn"
                    color="orange"
                ></v-text-field>
                <div v-if="speakersStore.error_linkedIn">
          <span class="text-sm text-red-400">
            {{speakersStore.error_linkedIn}}
          </span>
                </div>
                <v-text-field
                    v-model="facebook"
                    label="Facebook"
                    color="orange"
                ></v-text-field>
                <div v-if="speakersStore.error_facebook">
          <span class="text-sm text-red-400">
            {{speakersStore.error_facebook}}
          </span>
                </div>
                <v-text-field
                    v-model="twitter"
                    label="Twitter"
                    color="orange"
                ></v-text-field>
                <div v-if="speakersStore.error_twitter">
          <span class="text-sm text-red-400">
            {{speakersStore.error_twitter}}
          </span>
                </div>
                <v-file-input
                    v-model="addFile"
                    accept="image/png, image/jpeg, image/bmp"
                    :prepend-icon="null"
                    color="orange"
                    @change="onFileChange($event, 'add')"
                    label="Choose Image"
                ></v-file-input>
                <div v-if="speakersStore.error_image">
          <span class="text-sm text-red-400">
            {{speakersStore.error_image}}
          </span>
                </div>
                <v-img v-if="addImageUrl" :src="addImageUrl"></v-img>
              </div>
            </div>
            <v-btn class="mt-2" type="submit" @click="submitForm()" block>Save</v-btn>
          </v-form>
        </v-sheet>
        <br>

        <form class="flex items-center max-w-sm mx-auto" @submit.prevent="onSearch">
          <div class="relative w-full">
            <input type="text" v-model="search" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search..." required />
          </div>
          <button type="submit" class="p-2.5 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
            </svg>
            <span class="sr-only">Search</span>
          </button>
        </form>

        <br>
        <div class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
          <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
              <th scope="col" class="px-6 py-3">Image</th>
              <th scope="col" class="px-6 py-3">First Name</th>
              <th scope="col" class="px-6 py-3">Last Name</th>
              <th scope="col" class="px-6 py-3">Show/Update</th>
              <th scope="col" class="px-6 py-3">Delete</th>
            </tr>
            </thead>
            <tbody v-for="speakers in speakersStore.getSpeakers.data" :key="speakers.id">
            <tr v-if="speakers" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
              <td class="px-6 py-4">
                <img :src="'https://api.nconnect.mojawebka.eu/nConnect-Laravel/storage/' + speakers.picture" class="w-16 md:w-32 max-w-full max-h-full" alt="Speaker's Profile Picture">
              </td>
              <td class="px-6 py-4">
                {{ speakers.first_name }}
              </td>
              <td class="px-6 py-4">
                {{ speakers.last_name }}
              </td>
              <td class="px-6 py-4">
                <v-btn class="font-medium text-green-600 dark:text-green-500 hover:underline inline-block" @click="dialog = true,editSpeakers(speakers)">
                  Show/Update
                </v-btn>
              </td>
              <td class="px-6 py-4">
                <form @submit.prevent class="inline-block">
                  <v-btn @click="speakersStore.destroySpeakers(speakers.id)" color="red-lighten-2" text="Delete"></v-btn>
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
    <v-dialog v-model="dialog" width="auto" persistent>
      <v-card min-width="600" prepend-icon="mdi-update" title="Update Speaker">
        <v-card-text>
          <img :src="'https://api.nconnect.mojawebka.eu/nConnect-Laravel/storage/' + edit_speakers.picture" class="w-16 md:w-32 max-w-full max-h-full" alt="Speaker's Profile Picture">
          <input type="file" accept="image/*" @change="onFileChange($event, 'update')" class="mb-4">
          <v-text-field
              v-model="edit_speakers.first_name"
              label="First Name"
              color="orange"
          ></v-text-field>
          <v-text-field
              v-model="edit_speakers.last_name"
              label="Last Name"
              color="orange"
          ></v-text-field>
          <v-text-field
              v-model="edit_speakers.short_desc"
              label="Short Description"
              color="orange"
          ></v-text-field>
          <v-textarea
              v-model="edit_speakers.long_desc"
              label="Long Description"
              color="orange"
              row-height="25"
              rows="4"
              auto-grow
          ></v-textarea>
          <v-text-field
              v-model="edit_speakers.company"
              label="Company"
              color="orange"
          ></v-text-field>
          <v-text-field
              v-model="edit_speakers.instagram"
              label="Instagram"
              color="orange"
          ></v-text-field>
          <v-text-field
              v-model="edit_speakers.linkedIn"
              label="LinkedIn"
              color="orange"
          ></v-text-field>
          <v-text-field
              v-model="edit_speakers.facebook"
              label="Facebook"
              color="orange"
          ></v-text-field>
          <v-text-field
              v-model="edit_speakers.twitter"
              label="Twitter"
              color="orange"
          ></v-text-field>
        </v-card-text>
        <template v-slot:actions>
          <v-btn class="ms-auto" text="Close" @click="dialog = false, speakersStore.refreshSpeakers()"></v-btn>
          <v-btn class="font-medium text-green-600 dark:text-green-500 hover:underline" text="Update" @click="dialog = false,updateForm(edit_speakers)"></v-btn>
        </template>
      </v-card>
    </v-dialog>
    <v-dialog v-model="error_dialog" width="auto" persistent>
      <v-card min-width="600" prepend-icon="mdi-update" title="We couldn't perform the update. Please check the data you've entered and try again.">
        <v-card-text>
          <ul>
            <li v-for="(errors, fieldName) in speakersStore.errors_update" :key="fieldName">
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

    <div class="text-center">
      <v-pagination
          v-model="page"
          :length="speakersStore.getSpeakers.last_page"
          rounded="circle"
      ></v-pagination>
    </div>
  </div>



</template>
<script>
import {onMounted, watch} from 'vue'
import { initFlowbite } from 'flowbite'
import AdminNavComponent from "@/components/AdminNavComponent.vue";
import SuccessAlertComponent from "@/components/alerts/SuccessAlertComponent.vue";
import ErrorAlertComponent from "@/components/alerts/ErrorAlertComponent.vue";
import {useSpeakersStore} from "@/stores/SpeakersStore.js";


export default {
  components: {ErrorAlertComponent, SuccessAlertComponent, AdminNavComponent},
  data() {
    return {
      first_name: '',
      last_name: '',
      short_desc: '',
      long_desc: '',
      company: '',
      addFile: null,
      updateFile: null,
      addImageUrl: "",
      updateImageUrl: "",
      instagram: '',
      linkedIn: '',
      facebook: '',
      twitter: '',
      stages: [],
      errors: [],
      edit_speakers: [],
      dialog: false,
      error_dialog: false,
      page: 1,
      search: '',
      speakersStore: useSpeakersStore(),
    };
  },
  created(){
    this.speakersStore.fetchSpeakers();
    this.speakersStore.success = '';
  },
  mounted() {
    initFlowbite();
    watch(() => this.page, (newValue, oldValue) => {
      if (newValue) {
        this.speakersStore.fetchSpeakers(this.page, this.search)
      }
    });
  }
  ,
  methods:{
    editSpeakers(speakers){
      this.edit_speakers = speakers;
    },
    submitForm() {
      this.speakersStore.error_first_name = '';
      this.speakersStore.error_last_name = '';
      this.speakersStore.error_short_desc = '';
      this.speakersStore.error_long_desc = '';
      this.speakersStore.error_company = '';
      this.speakersStore.error_instagram = '';
      this.speakersStore.error_linkedIn = '';
      this.speakersStore.error_facebook = '';
      this.speakersStore.error_twitter = '';
      this.speakersStore.error_image = '';

      this.speakersStore.insertSpeakers(
          this.first_name, this.last_name, this.short_desc, this.long_desc, this.company,
          this.instagram, this.linkedIn, this.facebook, this.twitter, this.addFile
      );

      this.first_name = '';
      this.last_name = '';
      this.short_desc = '';
      this.long_desc = '';
      this.company = '';
      this.instagram = '';
      this.linkedIn = '';
      this.facebook = '';
      this.twitter = '';
      this.addFile = null;
      this.addImageUrl = '';
      this.addFileInput = '';
      this.addImageUrl = '';
      this.speakersStore.refreshSpeakers();
    },
    onSearch() {
      this.page = 1;
      this.speakersStore.fetchSpeakers(this.page, this.search);
    },
    updateForm(speakers) {
      this.speakersStore.updateSpeakers(speakers, this.updateFile);
      if (this.speakersStore.errors_update && Object.keys(this.speakersStore.errors_update).length > 0) {
        this.callErrorDialog();
      }
    },
    createImage(file, form) {
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
      const files = event.target.files;
      if (!files || files.length === 0) {
        console.log("No files selected.");
        return;
      }
      const file = files[0];
      if (form === 'update') {
        this.updateFile = file;
      } else {
        this.addFile = file;
      }
      this.createImage(file, form);
    },
    callErrorDialog() {
      this.error_dialog = true;
    },
    closeErrorDialog() {
      this.error_dialog = false;
      this.speakersStore.errors_update = [];
      this.speakersStore.fetchSpeakers();
    }
  }
}
</script>
