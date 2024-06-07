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
            <v-btn
                class="mt-2"
                type="submit"
                @click="submitForm()"
                block
            >Save</v-btn>
          </v-form>
        </v-sheet>

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
                  Delete
                </th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="stage in stageStore.current_stages" :key="stage.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                  {{stage.name}}
                </td>
                <td class="px-6 py-4">
                  {{stage.date}}
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
        stage:[],
        stages:[],
        available_stages:[],
        current_stages:[],
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
    }
    ,
    methods:{
      submitForm() {
        this.stageStore.addStageToConference(this.stage.id);
        this.stage=[];
      },
      updateForm(stage) {
        this.stageStore.updateStage(stage);
        this.stageStore.update_error_name = '';
        this.stageStore.update_error_date = '';
      },
      itemProps (item) {
        return {
          title: item.name,
          subtitle: item.date,
        }
      },
    }
  }
</script>
