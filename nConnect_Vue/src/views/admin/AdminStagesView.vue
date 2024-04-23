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
                :rules="rules"
                label="Name"
            ></v-text-field>

            <v-text-field
                v-model="date"
                :rules="rules"
                label="Date"
            ></v-text-field>

            <v-btn class="mt-2" type="submit" @click="stageStore.insertStage(name,date)" block>Save</v-btn>
          </v-form>
        </v-sheet>


        <form class="max-w-xl mx-auto">
          <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
          <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
              <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
              </svg>
            </div>
            <input type="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search" required />
            <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
          </div>
        </form>


        <div class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
          <div class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <div class="flex">
              <div class="flex-1 px-6 py-3">Stage name</div>
              <div class="flex-1 px-6 py-3">Date</div>
              <div class="flex-1 px-6 py-3">
                <span class="sr-only">Edit</span>
              </div>
              <div class="flex-1 px-6 py-3">
                <span class="sr-only">Delete</span>
              </div>
            </div>
          </div>
          <div v-for="stage in stageStore.getStages" :key="stage.id" class="flex bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 items-center">
            <form @submit.prevent class="flex-1">
              <div class="flex items-center justify-between px-6 py-4">
                <input type="hidden" v-model="stage.id">
                <input type="text" v-model="stage.name" placeholder="Name" class="flex-1 mr-2">
                <input type="text" v-model="stage.date" placeholder="Date" class="flex-1 mr-2">
                <button :disabled="dialog" class="font-medium text-green-600 dark:text-green-500 hover:underline" @click="stageStore.updateStage(stage);" type="submit">Update</button>
              </div>
            </form>
            <form @submit.prevent>
              <button :disabled="dialog" class="font-medium text-red-600 dark:text-red-500 hover:underline" type="submit" @click="stageStore.destroyStage(stage.id)">DELETE</button>
            </form>
          </div>
        </div>

      </div>

    </div>
  </div>



</template>
<script>
import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'
import {useStageStore} from "@/stores/StageStore.js";
import AdminNavComponent from "@/components/AdminNavComponent.vue";

// initialize components based on data attribute selectors
onMounted(() => {
  initFlowbite();
})

  export default {
    components: {AdminNavComponent},
    data(){
      return {
        name: '',
        date: '',
        rules: [
          value => {
            if (value) return true
            return 'You must enter a value.'
          },
        ],
        stages:[],
        stageStore: useStageStore(),
      };
    },
    created(){
      this.stageStore.fetchStages();
    }
  }
</script>
