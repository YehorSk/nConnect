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
            ></v-text-field>
            <div v-if="stageStore.error_name">
              <span class="text-sm text-red-400">
                {{stageStore.error_name}}
              </span>
            </div>
            <v-text-field
                v-model="date"
                label="Date"
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
          <div v-for="stage in stageStore.getStages" :key="stage.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 items-center">
            <div>
              <form @submit.prevent class="inline-block">
                <input type="hidden" v-model="stage.id">
                <input type="text" v-model="stage.name" placeholder="Name" class="inline-block mr-2">
                <input type="text" v-model="stage.date" placeholder="Date" class="inline-block mr-2">
                <button class="font-medium text-green-600 dark:text-green-500 hover:underline inline-block mr-2" @click="updateForm(stage)" type="submit">Update</button>
              </form>
              <form @submit.prevent class="inline-block">
                <button class="font-medium text-red-600 dark:text-red-500 hover:underline inline-block" type="submit" @click="stageStore.destroyStage(stage.id)">DELETE</button>
              </form>
            </div>
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

  </div>


  <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
      <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
      <tr>
        <th scope="col" class="px-6 py-3">
          Product name
        </th>
        <th scope="col" class="px-6 py-3">
          Color
        </th>
        <th scope="col" class="px-6 py-3">
          Category
        </th>
        <th scope="col" class="px-6 py-3">
          Price
        </th>
        <th scope="col" class="px-6 py-3">
          Action
        </th>
      </tr>
      </thead>
      <tbody>
      <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
          Apple MacBook Pro 17"
        </th>
        <td class="px-6 py-4">
          Silver
        </td>
        <td class="px-6 py-4">
          Laptop
        </td>
        <td class="px-6 py-4">
          $2999
        </td>
        <td class="px-6 py-4">
          <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
        </td>
      </tr>
      <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
          Microsoft Surface Pro
        </th>
        <td class="px-6 py-4">
          White
        </td>
        <td class="px-6 py-4">
          Laptop PC
        </td>
        <td class="px-6 py-4">
          $1999
        </td>
        <td class="px-6 py-4">
          <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
        </td>
      </tr>
      <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
          Magic Mouse 2
        </th>
        <td class="px-6 py-4">
          Black
        </td>
        <td class="px-6 py-4">
          Accessories
        </td>
        <td class="px-6 py-4">
          $99
        </td>
        <td class="px-6 py-4">
          <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
        </td>
      </tr>
      <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
          Google Pixel Phone
        </th>
        <td class="px-6 py-4">
          Gray
        </td>
        <td class="px-6 py-4">
          Phone
        </td>
        <td class="px-6 py-4">
          $799
        </td>
        <td class="px-6 py-4">
          <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
        </td>
      </tr>
      <tr>
        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
          Apple Watch 5
        </th>
        <td class="px-6 py-4">
          Red
        </td>
        <td class="px-6 py-4">
          Wearables
        </td>
        <td class="px-6 py-4">
          $999
        </td>
        <td class="px-6 py-4">
          <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
        </td>
      </tr>
      </tbody>
    </table>
  </div>




</template>
<script>
import { onMounted } from 'vue'
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
        stages:[],
        errors:[],
        stageStore: useStageStore(),
      };
    },
    created(){
      this.stageStore.fetchStages();
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
