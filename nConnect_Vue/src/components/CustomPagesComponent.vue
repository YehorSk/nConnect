<template>
  <div class="row">
    <v-col  v-for="page in editorStore.getPages" :key="page.id" cols="12" md="4">
      <v-card>
        <v-card-title>{{ page.name}}</v-card-title>
        <v-card-item>{{stripHtmlTags(page.content)}}</v-card-item>
      </v-card>
      <v-card-actions>
        <v-btn
            color="green-lighten-2"
            text="Update"
        ></v-btn>
        <v-btn @click="editorStore.destroyPage(page.id)"
            color="red-lighten-2"
            text="Delete"
        ></v-btn>
      </v-card-actions>
    </v-col>
  </div>

</template>
<script >
import {stripHtmlTags, useEditorStore} from "@/stores/EditorStore.js";
import {initFlowbite} from "flowbite";

export default {
  data(){
    return {
      editorStore: useEditorStore(),
    };
  },
  created(){
    this.editorStore.fetchPages();
  },
  mounted() {
    initFlowbite();
  },
  methods: {
    stripHtmlTags
  }
}
</script>