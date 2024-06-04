<template>
  <section class="section schedule">
    <div class="container">
      <div class="row justify-center align-items-center" >
        <div v-if="waiting">
          <v-progress-circular
              :size="80"
              :width="7"
              color="primary"
              indeterminate
          ></v-progress-circular>
        </div>
          <div class="row justify-content-center" v-else>
            <div v-for="page in editorStore.getPages" :key="page.id" class="col-lg-3 col-md-4 col-sm-6 mx-auto">
              <div class="speaker-item">
                <div class="content text-center">
                  <h5><router-link :to="`/get-page/${page.id}`">{{ page.name }}</router-link></h5>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
  </section>
</template>
<script>
import { useEditorStore } from "@/stores/EditorStore.js";

export default {
  data() {
    return {
      editorStore: useEditorStore(),
      waiting:false,
    };
  },
  async created() {
    this.waiting = true;
    await this.editorStore.fetchPages();
    this.waiting = false;
  }
};
</script>
