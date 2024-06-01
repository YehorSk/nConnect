<style scoped>
@import '/src/assets/main.css';
</style>
<template>
  <AdminNavComponent/>
  <div class="p-4 sm:ml-64 ">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
      <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <TipTapComponent/>
      </div>
<!--      <div class="relative overflow-x-auto shadow-md sm:rounded-lg">-->
<!--        <CustomPagesComponent/>-->
<!--      </div>-->
    </div>
  </div>
</template>
<script>
import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'
import AdminNavComponent from "@/components/AdminNavComponent.vue";
import SuccessAlertComponent from "@/components/alerts/SuccessAlertComponent.vue";
import ErrorAlertComponent from "@/components/alerts/ErrorAlertComponent.vue";
import TipTapComponent from "@/components/TipTapComponent.vue";
import CustomPagesComponent from "@/components/CustomPagesComponent.vue";


export default {
  components: {
    CustomPagesComponent, TipTapComponent, ErrorAlertComponent, SuccessAlertComponent, AdminNavComponent},
  mounted() {
    initFlowbite();
  },
  data() {
    return {

    };
  },
  created() {

  },
  methods: {


  },
}
</script>
