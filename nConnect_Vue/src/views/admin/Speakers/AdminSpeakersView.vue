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
                ></v-text-field>
                <div v-if="speakersStore.error_first_name">
          <span class="text-sm text-red-400">
            {{speakersStore.error_first_name}}
          </span>
                </div>
                <v-text-field
                    v-model="last_name"
                    label="Last Name"
                ></v-text-field>
                <div v-if="speakersStore.error_last_name">
          <span class="text-sm text-red-400">
            {{speakersStore.error_last_name}}
          </span>
                </div>
                <v-text-field
                    v-model="short_desc"
                    label="Short Description"
                ></v-text-field>
                <div v-if="speakersStore.error_short_desc">
          <span class="text-sm text-red-400">
            {{speakersStore.error_short_desc}}
          </span>
                </div>
                <v-textarea
                    v-model="long_desc"
                    label="Long Description"
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
                ></v-text-field>
                <div v-if="speakersStore.error_instagram">
          <span class="text-sm text-red-400">
            {{speakersStore.error_instagram}}
          </span>
                </div>
                <v-text-field
                    v-model="linkedIn"
                    label="LinkedIn"
                ></v-text-field>
                <div v-if="speakersStore.error_linkedIn">
          <span class="text-sm text-red-400">
            {{speakersStore.error_linkedIn}}
          </span>
                </div>
                <v-text-field
                    v-model="facebook"
                    label="Facebook"
                ></v-text-field>
                <div v-if="speakersStore.error_facebook">
          <span class="text-sm text-red-400">
            {{speakersStore.error_facebook}}
          </span>
                </div>
                <v-text-field
                    v-model="twitter"
                    label="Twitter"
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
                    color="black"
                    @change="onFileChange($event, 'add')"
                    label="Choose Image"
                ></v-file-input>
                <div v-if="speakersStore.error_image">
          <span class="text-sm text-red-400">
            {{speakersStore.error_image}}
          </span>
                </div>
                <v-img :src="addImageUrl"></v-img>
              </div>
            </div>
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
                First Name
              </th>
              <th scope="col" class="px-6 py-3">
                Last Name
              </th>
              <th scope="col" class="px-6 py-3">
                Show/Update
              </th>
              <th scope="col" class="px-6 py-3">
                Delete
              </th>
            </tr>
            </thead>
            <tbody v-for="speakers in speakersStore.getSpeakers" :key="speakers.id">
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
              <td class="p-4">
                <img :src="'http://127.0.0.1:8000/storage/' + speakers.picture" class="w-32 md:w-64 max-w-full max-h-full" alt="Speaker's Profile Picture">
              </td>
              <td>
                {{ speakers.first_name }}
              </td>
              <td>
                {{ speakers.last_name }}
              </td>
              <td>
                <v-btn class="font-medium text-green-600 dark:text-green-500 hover:underline inline-block" @click="dialog = true,editSpeakers(speakers)">
                  Show/Update
                </v-btn>
                <v-dialog v-model="dialog" width="auto" persistent>
                  <v-card min-width="600" prepend-icon="mdi-update" title="Update Speaker">
                    <v-card-text>
                      <img :src="'http://127.0.0.1:8000/storage/' + edit_speakers.picture" class="w-32 md:w-64 max-w-full max-h-full mb-4" alt="Speaker's Profile Picture">
                      <input type="file" accept="image/*" @change="onFileChange($event, 'update')" class="mb-4">
                      <v-text-field
                          v-model="edit_speakers.first_name"
                          label="First Name"
                      ></v-text-field>
                      <v-text-field
                          v-model="edit_speakers.last_name"
                          label="Last Name"
                      ></v-text-field>
                      <v-text-field
                          v-model="edit_speakers.short_desc"
                          label="Short Description"
                      ></v-text-field>
                      <v-textarea
                          v-model="edit_speakers.long_desc"
                          label="Long Description"
                          row-height="25"
                          rows="4"
                          auto-grow
                      ></v-textarea>
                      <v-text-field
                          v-model="edit_speakers.company"
                          label="Company"
                      ></v-text-field>
                      <v-text-field
                          v-model="edit_speakers.instagram"
                          label="Instagram"
                      ></v-text-field>
                      <v-text-field
                          v-model="edit_speakers.linkedIn"
                          label="LinkedIn"
                      ></v-text-field>
                      <v-text-field
                          v-model="edit_speakers.facebook"
                          label="Facebook"
                      ></v-text-field>
                      <v-text-field
                          v-model="edit_speakers.twitter"
                          label="Twitter"
                      ></v-text-field>
                    </v-card-text>
                    <template v-slot:actions>
                      <v-btn class="ms-auto" text="Close" @click="dialog = false, speakersStore.refreshSpeakers()"></v-btn>
                      <v-btn class="font-medium text-green-600 dark:text-green-500 hover:underline" text="Update" @click="dialog = false,updateForm(edit_speakers)"></v-btn>
                    </template>
                  </v-card>
                </v-dialog>
              </td>
              <td>
                <form @submit.prevent class="inline-block">
                  <button class="font-medium text-red-600 dark:text-red-500 hover:underline inline-block" type="submit" @click="speakersStore.destroySpeakers(speakers.id)">DELETE</button>
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
  data(){
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
      stages:[],
      errors:[],
      edit_speakers:[],
      dialog:false,
      error_dialog:false,

      speakersStore: useSpeakersStore(),
    };
  },
  created(){
    this.speakersStore.fetchSpeakers();
    this.speakersStore.success = '';
  },
  mounted() {
    initFlowbite();
    watch(() => this.speakersStore.errors_update, (newValue, oldValue) => {
      if (newValue && newValue.length !== 0) {
        this.callErrorDialog();
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
      this.$refs.addFileInput.value = '';
      this.$refs.addImageUrl.value = '';
    },
    updateForm(speakers) {
      console.log("File:", this.file);
      this.speakersStore.updateSpeakers(speakers, this.updateFile);

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
    callErrorDialog(){
      this.error_dialog = true;
    },
    closeErrorDialog(){
      this.error_dialog = false;
      this.speakersStore.errors_update=[];
      this.speakersStore.fetchSpeakers();
    }



  }
}
</script>
