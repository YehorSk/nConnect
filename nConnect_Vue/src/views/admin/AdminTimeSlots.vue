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
                v-model="start_time"
                type="time"
                label="Start Time"
            ></v-text-field>
            <v-text-field
                v-model="end_time"
                type="time"
                label="End Time"
            ></v-text-field>
            <div v-if="timeSlotStore.error_time">
              <span class="text-sm text-red-400">
                {{timeSlotStore.error_time}}
              </span>
            </div>
            <v-btn class="mt-2" type="submit" @click="submitForm()" block>Save</v-btn>
          </v-form>
        </v-sheet>

        <br>
        <div class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
          <div v-for="slot in timeSlotStore.getSlots" :key="slot.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 items-center">
            <div>
              <form @submit.prevent class="inline-block">
                <input type="hidden" v-model="slot.id">
                <input type="time" v-model="slot.start_time" placeholder="Start Time" class="inline-block mr-2">
                <input type="time" v-model="slot.end_time" placeholder="End Time" class="inline-block mr-2">
                <button class="font-medium text-green-600 dark:text-green-500 hover:underline inline-block mr-2" @click="updateTimeSlot(slot)" type="submit">Update</button>
              </form>
              <form @submit.prevent class="inline-block">
                <button class="font-medium text-red-600 dark:text-red-500 hover:underline inline-block" type="submit" @click="timeSlotStore.deleteTimeSlot(slot.id)">DELETE</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div v-if="timeSlotStore.success" id="alert-3" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        <SuccessAlertComponent :message="timeSlotStore.success"/>
    </div>
    <div v-if="timeSlotStore.update_error_time" id="alert-2" class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
      <ErrorAlertComponent :message="timeSlotStore.update_error_time"/>
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
import {useTimeSlotStore} from "@/stores/TimeSlotStore.js";


  export default {
    components: {ErrorAlertComponent, SuccessAlertComponent, AdminNavComponent},
    data(){
      return {
        name: '',
        start_time: '',
        end_time: '',
        stages:[],
        timeslots:[],
        errors:[],
        timeSlotStore: useTimeSlotStore(),
        stageStore: useStageStore(),
      };
    },
    created(){
      this.stageStore.fetchStages();
      this.timeSlotStore.fetchTimeSlotsByStageId(this.$route.params.id);
    },
    mounted() {
      initFlowbite();
    }
    ,
    methods:{
      submitForm() {
        this.timeSlotStore.saveTimeSlot(this.$route.params.id, this.start_time, this.end_time);
        this.start_time = '';
        this.end_time = '';
        this.timeSlotStore.error_time = '';
      },
      updateTimeSlot(slot) {
        this.timeSlotStore.updateTimeSlot(slot);
        this.timeSlotStore.update_error_time = '';
      }
    }
  }
</script>
