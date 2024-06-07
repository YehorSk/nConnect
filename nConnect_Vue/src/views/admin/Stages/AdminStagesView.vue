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
            <v-text-field
                v-model="name"
                label="Name"
                color="orange"
            ></v-text-field>
            <div v-if="stageStore.error_name">
              <span class="text-sm text-red-400">
                {{stageStore.error_name}}
              </span>
            </div>
            <v-text-field
                v-model="date"
                label="Date"
                color="orange"
            ></v-text-field>
            <div v-if="stageStore.error_date">
              <span class="text-sm text-red-400">
                {{stageStore.error_date}}
              </span>
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
              <th scope="col" class="px-6 py-3">Update</th>
              <th scope="col" class="px-6 py-3">Delete</th>
            </tr>
            </thead>
            <tbody v-for="stage in stageStore.getStages" :key="stage.id">
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
              <td class="px-6 py-4">
                <input type="text" v-model="stage.name" placeholder="name" class="inline-block w-full">
              </td>
              <td class="px-6 py-4">
                <input type="text" v-model="stage.date" placeholder="date" class="inline-block w-full">
              </td>
              <td class="px-6 py-4">
                <v-btn @click="updateForm(stage)"
                       color="green-lighten-2"
                       text="Update"
                ></v-btn>
              </td>
              <td class="px-6 py-4">
                <form @submit.prevent class="inline-block">
                  <v-btn @click="stageStore.destroyStage(stage.id)"
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

    <div v-if="stageStore.success" id="alert-3" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        <SuccessAlertComponent :message="stageStore.success"/>
    </div>
    <div v-if="stageStore.update_error_name" id="alert-2" class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
      <ErrorAlertComponent :message="stageStore.update_error_name"/>
    </div>
    <div v-if="stageStore.update_error_date" id="alert-2" class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
      <ErrorAlertComponent :message="stageStore.update_error_date"/>
    </div>

  </div>

</template>
<script>
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
        date:'',
        stages:[],
        errors:[],
        stageStore: useStageStore(),
      };
    },
    created(){
      this.stageStore.fetchStages();
      this.stageStore.success = '';
    },
    mounted() {
      initFlowbite();
    }
    ,
    methods:{
      submitForm() {
        this.stageStore.insertStage(this.name, this.date);
        this.stageStore.error_name = '';
        this.stageStore.error_date = '';
        this.name = '';
        this.date = '';
      },
      updateForm(stage) {
        this.stageStore.updateStage(stage);
        this.stageStore.update_error_name = '';
        this.stageStore.update_error_date = '';
      }
    }
  }
</script>
