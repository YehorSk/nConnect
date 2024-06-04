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
  <section>
    <div class="container mx-auto max-w-4xl my-8">
      <div class="editor">
        <editor-content :editor="editor" />
      </div>
    </div>
  </section>
  <FooterComponent/>
</template>
<script>
import { useEditorStore, stripHtmlTags } from "@/stores/EditorStore.js";
import FooterComponent from "@/components/FooterComponent.vue";
import NavigationComponent from "@/components/NavigationComponent.vue";
import StarterKit from '@tiptap/starter-kit'
import { Editor, EditorContent } from '@tiptap/vue-3'
import Image from '@tiptap/extension-image'
import Text from '@tiptap/extension-text'
import TextAlign from '@tiptap/extension-text-align'
import Document from '@tiptap/extension-document'
import ImageResize from 'tiptap-extension-resize-image';
import Youtube from '@tiptap/extension-youtube';
import Heading from '@tiptap/extension-heading'
import Paragraph from '@tiptap/extension-paragraph'
import { Color } from '@tiptap/extension-color';
import TextStyle from '@tiptap/extension-text-style';
export default {
  components: {NavigationComponent, FooterComponent,EditorContent},
  data() {
    return {
      page: null,
      editor: null,
      editable: false,
    };
  },
  async created() {
    const editorStore = useEditorStore();
    const pageId = this.$route.params.id;
    try {
      this.page = await editorStore.fetchPageById(pageId);
      console.log(this.page.content);
    } catch (error) {
      console.error('Error fetching page:', error);
    }
  },
  methods: {
    stripHtmlTags
  },
  mounted() {
    this.editor = new Editor({
      editable: this.editable,
      content: '',
      extensions: [
        StarterKit,
        Document,
        Text,
        TextStyle,
        Color,
        // Image.configure({
        //   HTMLAttributes: {
        //     class: 'image-custom-class',
        //   },
        // }),
          ImageResize.configure(
              {
                HTMLAttributes: {
                  class: 'image-custom-class',
                },
              }
          ),
        Youtube.configure({
          controls: false,
          nocookie: true,
        }),
        Heading,
        Paragraph,
        TextAlign.configure({
          types: ['heading', 'paragraph'],
        }),
      ],
    });
    this.editor.commands.setContent(this.page.content);
  },

  watch: {
    editable() {
      this.editor.setEditable(this.editable)
    },
  },

  beforeUnmount() {
    this.editor.destroy()
  },
};
</script>
<style>
.image-custom-class {
  display:flex;
  margin-left: auto;
  margin-right: auto;
}
.video-custom-class {
  display: block;
  margin-left: auto;
  margin-right: auto;
}
</style>
