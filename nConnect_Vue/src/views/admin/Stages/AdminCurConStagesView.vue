<style scoped>
@import '/src/assets/main.css';
</style>
<template>
  <AdminNavComponent/>

  <div class="p-4 sm:ml-64 ">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">


      <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

        <v-sheet class="max-w-sm ">
          <v-form fast-fail @submit.prevent>
            <v-select
                :item-props="itemProps"
                color="orange"
                v-model="stage"
                :items="stageStore.getAvailableStages"
                label="Available Stages"
            ></v-select>
            <v-text-field
                v-model="date"
                label="Date"
                color="orange"
            ></v-text-field>
            <v-btn
                class="mt-2"
                type="submit"
                @click="submitForm()"
                block
            >Save</v-btn>
          </v-form>
        </v-sheet>
        <br>

        <form class="flex items-center max-w-sm mx-auto" @submit.prevent>
          <div class="relative w-full">
            <input type="text" v-model="search" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search..." required />
          </div>
          <button type="submit" @click="stageStore.fetchCurrentConferenceStages(1,search)"  class="p-2.5 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
            </svg>
            <span class="sr-only">Search</span>
          </button>
        </form>

        <br>
        <div class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
          <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
              <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
              <tr>
                <th scope="col" class="px-6 py-3">
                  Name
                </th>
                <th scope="col" class="px-6 py-3">
                  Year
                </th>
                <th scope="col" class="px-6 py-3">
                  Update
                </th>
                <th scope="col" class="px-6 py-3">
                  Delete
                </th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="stage in stageStore.current_stages.data" :key="stage.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                  {{stage.name}}
                </td>
                <td class="px-6 py-4">
                  <v-text-field
                      v-model="stage.pivot.date"
                      label="Date"
                      color="orange"
                  ></v-text-field>
                </td>
                <td class="px-6 py-4">
                  <v-btn class="font-medium text-green-600 dark:text-green-500 hover:underline" text="Update" @click="stageStore.updateStageInConference(stage)"></v-btn>
                </td>
                <td class="px-6 py-4">
                  <form @submit.prevent class="inline-block">
                    <v-btn @click="stageStore.deleteStageFromConference(stage.id)"
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
    </div>

    <div v-if="stageStore.success" id="alert-3" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        <SuccessAlertComponent :message="stageStore.success"/>
    </div>
    <div v-if="stageStore.update_error_name" id="alert-2" class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
      <ErrorAlertComponent :message="stageStore.update_error_name"/>
    </div>
    <div v-if="stageStore.update_error_date" id="alert-2" class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
      <ErrorAlertComponent :message="stageStore.update_error_date"/>
    </div>

    <div class="text-center">
      <v-pagination
          v-model="page"
          :length="stageStore.current_stages.last_page"
          rounded="circle"
      ></v-pagination>
    </div>

  </div>



</template>
<script>
import {onMounted, watch} from 'vue'
import { initFlowbite } from 'flowbite'
import {useStageStore} from "@/stores/StageStore.js";
import AdminNavComponent from "@/components/AdminNavComponent.vue";
import SuccessAlertComponent from "@/components/alerts/SuccessAlertComponent.vue";
import ErrorAlertComponent from "@/components/alerts/ErrorAlertComponent.vue";


  export default {
    components: {ErrorAlertComponent, SuccessAlertComponent, AdminNavComponent},
    data(){
      return {
        name: '',
        date: '',
        stage:[],
        stages:[],
        available_stages:[],
        current_stages:[],
        page:1,
        search:'',
        errors:[],
        stageStore: useStageStore(),
      };
    },
    created(){
      this.stageStore.fetchCurrentConferenceStages();
      this.stageStore.fetchAvailableStages();
      this.stageStore.success = '';
    },
    mounted() {
      initFlowbite();
      watch(() => this.page, (newValue, oldValue) => {
        if (newValue) {
          this.stageStore.fetchCurrentConferenceStages(this.page)
        }
      });
    }
    ,
    methods:{
      submitForm() {
        this.stageStore.addStageToConference(this.stage.id,this.date);
        this.stage=[];
        this.date = '';
      },
      updateForm(stage) {
        this.stageStore.updateStage(stage);
        this.stageStore.update_error_name = '';
        this.stageStore.update_error_date = '';
      },
      itemProps (item) {
        return {
          title: item.name
        }
      },
    }
  }
</script>
