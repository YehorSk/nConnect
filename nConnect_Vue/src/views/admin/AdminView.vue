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
            <div v-if="conferenceStore.error_name">
              <span class="text-sm text-red-400">{{conferenceStore.error_name}}</span>
            </div>
            <v-text-field v-model="date" label="Date"></v-text-field>
            <div v-if="conferenceStore.error_year">
              <span class="text-sm text-red-400">{{conferenceStore.error_date}}</span>
            </div>
            <v-btn class="mt-2" type="submit" @click="submitForm()" block>Save</v-btn>
          </v-form>
        </v-sheet>
        <br>
        <div class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
          <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
              <th scope="col" class="px-6 py-3">Name</th>
              <th scope="col" class="px-6 py-3">Date</th>
              <th scope="col" class="px-6 py-3">Current</th>
              <th scope="col" class="px-6 py-3">Update</th>
              <th scope="col" class="px-6 py-3">Delete</th>
            </tr>
            </thead>
            <tbody v-for="conference in conferenceStore.getConferences" :key="conference.id">
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
              <td class="px-6 py-4"><input type="text" v-model="conference.name" placeholder="Name" class="w-full"></td>
              <td class="px-6 py-4"><input type="text" v-model="conference.year" placeholder="Date" class="w-full"></td>
              <td class="px-6 py-4">
                <label class="inline-flex items-center cursor-pointer">
                  <input type="checkbox" class="sr-only peer" @change="updateIsCurrent($event, conference)" :checked="conference.is_current === 1">
                  <div class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                  <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Is current</span>
                </label>
              </td>
              <td class="px-6 py-4">
                <v-btn @click="updateForm(conference)"
                       color="green-lighten-2"
                       text="Update"
                ></v-btn>
              </td>
              <td class="px-6 py-4">
                <v-btn @click="conferenceStore.destroyConference(conference.id)"
                       color="red-lighten-2"
                       text="Delete"
                ></v-btn>
              </td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div v-if="conferenceStore.success" id="alert-3" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
      <SuccessAlertComponent :message="conferenceStore.success"/>
    </div>
    <div v-if="conferenceStore.update_error_name" id="alert-2" class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
      <ErrorAlertComponent :message="conferenceStore.update_error_name"/>
    </div>
    <div v-if="conferenceStore.error" id="alert-2" class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
      <ErrorAlertComponent :message="conferenceStore.error"/>
    </div>
    <div v-if="conferenceStore.update_error_year" id="alert-2" class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
      <ErrorAlertComponent :message="conferenceStore.update_error_year"/>
    </div>
    <div v-if="conferenceStore.update_error_current" id="alert-2" class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
      <ErrorAlertComponent :message="conferenceStore.update_error_current"/>
    </div>
  </div>

</template>
<script>
import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'
import {UseConferenceStore} from "@/stores/ConferenceStore.js"
import AdminNavComponent from "@/components/AdminNavComponent.vue";
import SuccessAlertComponent from "@/components/alerts/SuccessAlertComponent.vue";
import ErrorAlertComponent from "@/components/alerts/ErrorAlertComponent.vue";


export default{
  components: {ErrorAlertComponent, SuccessAlertComponent, AdminNavComponent},
  data(){
    return{
      name: '',
      date: '',
      is_current: 0,
      conferences:[],
      conferenceStore: UseConferenceStore(),
    };
  },
  created(){
    this.conferenceStore.fetchConferences();
    this.conferenceStore.success = '';
  },
  mounted() {
    initFlowbite();
  }
  ,
  methods:{
    submitForm() {
      this.conferenceStore.insertConference(this.name, this.date);
      this.name = '';
      this.date = '';
    },
    updateForm(conference) {
      this.conferenceStore.updateConference(conference);
    },
    updateIsCurrent(event, conference) {
      conference.is_current = event.target.checked ? 1 : 0;
    }
  }
}
</script>