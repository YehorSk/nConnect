<style scoped>
@import '/src/assets/main.css';
</style>
<template>
  <AdminNavComponent/>
  <div class="p-4 sm:ml-64 ">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">

      <h1>Users</h1>

    </div>

  </div>
</template>
<script>
import { initFlowbite } from 'flowbite'
import AdminNavComponent from "@/components/AdminNavComponent.vue";
import {defineComponent} from "vue";
import ErrorAlertComponent from "@/components/alerts/ErrorAlertComponent.vue";
import SuccessAlertComponent from "@/components/alerts/SuccessAlertComponent.vue";

export default {
  components: {ErrorAlertComponent, SuccessAlertComponent, AdminNavComponent},
  data(){
    return {

    };
  },
  mounted() {
    initFlowbite();
  }


}

</script>