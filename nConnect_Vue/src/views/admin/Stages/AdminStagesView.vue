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
        date:'',
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
