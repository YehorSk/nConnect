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

            <v-text-field
                v-model="capacity"
                label="Capacity"
                type="number"
            ></v-text-field>

            <v-text-field
                v-model="start_time"
                label="Start time"
                type="time"
            ></v-text-field>
            <v-text-field
                v-model="end_time"
                label="End time"
                type="time"
            ></v-text-field>

            <v-btn class="mt-2" type="submit" @click="submitForm()" block>Save</v-btn>
          </v-form>
        </v-sheet>

        <br>
        <div class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
          <div v-for="lecture in lectureStore.getCurrentLectures" :key="lecture.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 items-center">
            <div>
              <form @submit.prevent class="inline-block">
                <input type="hidden" v-model="lecture.id">
                <input type="text" v-model="lecture.name" placeholder="Name" class="inline-block mr-2">
                <input type="number" v-model="lecture.capacity" placeholder="Capacity" class="inline-block mr-2">
                <input type="time" v-model="lecture.start_time" placeholder="Start time" class="inline-block mr-2">
                <input type="time"  v-model="lecture.end_time" placeholder="End time" class="inline-block mr-2">
                <input type="text" v-model="lecture.short_desc" placeholder="Short description" class="inline-block mr-2">
                <input type="text" v-model="lecture.long_desc" placeholder="Long description" class="inline-block mr-2">
                <v-select label="Available Stages"></v-select>
                <button class="font-medium text-green-600 dark:text-green-500 hover:underline inline-block mr-2" @click="updateForm(lecture)" type="submit">Update</button>
              </form>
              <v-textarea class="inline-block" label="Speaker"></v-textarea>
              <v-textarea class="inline-block"  label="Stage"></v-textarea>
              <form @submit.prevent class="inline-block">
                <button class="font-medium text-red-600 dark:text-red-500 hover:underline inline-block" type="submit" @click="lectureStore.destroyLecture(lecture.id)">DELETE</button>
              </form>
              <v-dialog max-width="700">
                <template v-slot:activator="{ props: activatorProps }">
                  <v-btn
                      v-bind="activatorProps"
                      color="surface-variant"
                      text="Assign"
                      variant="flat"
                  ></v-btn>
                </template>
                <template v-slot:default="{ isActive }">
                  <v-card>
                    <v-select label="Select Stage"></v-select>
                    <v-select label="Select Speaker"></v-select>

                    <v-card-actions>
                      <v-spacer></v-spacer>
                      <v-btn
                          text="Close"
                          @click="isActive.value = false"
                      ></v-btn>
                    </v-card-actions>
                  </v-card>
                </template>
              </v-dialog>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div v-if="lectureStore.success" id="alert-3" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
      <SuccessAlertComponent :message="lectureStore.success"/>
    </div>
  </div>



</template>
<script>
import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'
import {useLectureStore} from "@/stores/LectureStore.js";
import AdminNavComponent from "@/components/AdminNavComponent.vue";
import SuccessAlertComponent from "@/components/alerts/SuccessAlertComponent.vue";
import ErrorAlertComponent from "@/components/alerts/ErrorAlertComponent.vue";


export default {
  components: {ErrorAlertComponent, SuccessAlertComponent, AdminNavComponent},
  data(){
    return {
      name: '',
      capacity: '',
      start_time: '',
      end_time: '',
      short_desc: '',
      long_desc:'',
      lectures:[],
      errors:[],
      lectureStore: useLectureStore(),
    };
  },
  created(){
    this.lectureStore.fetchCurrentConferenceLectures();
  },
  mounted() {
    initFlowbite();
  }
  ,
  methods:{
    submitForm() {
      this.lectureStore.insertLecture(this.name, this.capacity, this.start_time, this.end_time, this.short_desc,this.long_desc);
      this.name = '';
      this.capacity = '';
      this.start_time='';
      this.end_time='';
      this.short_desc='';
      this.long_desc='';

    },
    updateForm(lecture) {
      this.lectureStore.updateLecture(lecture);
    }
  }
}
</script>
