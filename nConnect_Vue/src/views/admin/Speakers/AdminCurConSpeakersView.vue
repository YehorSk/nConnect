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
            <v-select :item-props="itemProps" v-model="speaker" :items="speakersStore.getAvailableSpeakers" label="Available Speakers"></v-select>
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
                Short Description
              </th>
              <th scope="col" class="px-6 py-3">
                Long Description
              </th>
              <th scope="col" class="px-6 py-3">
                Company
              </th>
              <th scope="col" class="px-6 py-3">
                Instagram
              </th>
              <th scope="col" class="px-6 py-3">
                LinkedIn
              </th>
              <th scope="col" class="px-6 py-3">
                Facebook
              </th>
              <th scope="col" class="px-6 py-3">
                Twitter
              </th>
              <th scope="col" class="px-6 py-3">
                Delete
              </th>
            </tr>
            </thead>
            <tbody v-for="speaker in speakersStore.getCurrentSpeakers" :key="speaker.id">
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
              <td class="p-4">
                <img :src="'http://127.0.0.1:8000/storage/' + speaker.picture" class="w-32 md:w-64 max-w-full max-h-full" alt="Apple Watch">
              </td>
              <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                {{speaker.first_name}}
              </td>
              <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                {{speaker.last_name}}
              </td>
              <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                {{speaker.short_desc}}
              </td>
              <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                {{speaker.long_desc}}
              </td>
              <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                {{speaker.company}}
              </td>
              <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                {{speaker.instagram}}
              </td>
              <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                {{speaker.linkedIn}}
              </td>
              <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                {{speaker.facebook}}
              </td>
              <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                {{speaker.twitter}}
              </td>
              <td>
                <form @submit.prevent class="inline-block">
                  <button class="font-medium text-red-600 dark:text-red-500 hover:underline inline-block" type="submit" @click="speakersStore.deleteSpeakersFromConference(speaker.id)">DELETE</button>
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

  </div>



</template>
<script>
import { onMounted } from 'vue'
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
      file: null,
      imageUrl: "",
      instagram: '',
      linkedIn: '',
      facebook: '',
      twitter: '',
      stages:[],
      errors:[],
      speaker:[],
      speakersStore: useSpeakersStore(),
    };
  },
  created(){
    this.speakersStore.fetchSpeakers();
    this.speakersStore.fetchCurrentConferenceSpeakers();
    this.speakersStore.fetchAvailableSpeakers();
  },
  mounted() {
    initFlowbite();
  }
  ,
  methods:{
    submitForm() {
      this.speakersStore.addSpeakersToConference(this.speaker.id);
      this.speaker=[];
    },
    itemProps (item) {
      return {
        title: item.first_name,
        subtitle: item.last_name,
      }
    },
  }
}
</script>
