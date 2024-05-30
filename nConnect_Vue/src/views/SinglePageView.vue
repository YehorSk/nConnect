<template>
  <NavigationComponent/>
  <section class="page-title bg-title overlay-dark">
    <div class="container">
      <div class="row">
        <div class="col-12 text-center">
          <div class="section-title">
            <h5>{{page.name}}</h5>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="section schedule">
    <div class="container">
      <div class="row">
        <div class="row justify-content-center">
            <div class="speaker-item">
              <div class="content text-center">
                <p>{{stripHtmlTags(page.content)}}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <FooterComponent/>
</template>
<script>
import { useEditorStore, stripHtmlTags } from "@/stores/EditorStore.js";
import FooterComponent from "@/components/FooterComponent.vue";
import NavigationComponent from "@/components/NavigationComponent.vue";
export default {
  components: {NavigationComponent, FooterComponent},
  data() {
    return {
      page: null
    };
  },
  async created() {
    const editorStore = useEditorStore();
    const pageId = this.$route.params.id;
    try {
      this.page = await editorStore.fetchPageById(pageId);
    } catch (error) {
      console.error('Error fetching page:', error);
    }
  },
  methods: {
    stripHtmlTags
  }
};
</script>
