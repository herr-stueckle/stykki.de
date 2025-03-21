
<template>
  <div class="project-wrapper">
   
    <div  v-html="pagecontent?.content" class="textFrame">

    </div>
  </div>  
</template>

<div
      v-if="id >= 0 && photoProjectList.currentSlide === -1"
      v-html="projectDescription"
      class="intro"
      :class="projectRatio + 'TextFrame'"
      @click="nextSlide"
    ></div>

<script lang="ts" setup>
import { defineProps, onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
import { usePages } from '../stores/pages';

interface Page {
  title: string;
  title_en: string; 
  content: string;
  content_en: string;
}


const route = useRoute();
const pages = usePages();
const pageId = ref(route.query.id as string | undefined); // Type assertion for better accuracy
const pagecontent = ref<Page | null>(null);



defineProps({
  id: String
})

onMounted(()=>{
  if (pageId.value) {
    const page = pages.getPage(pageId.value);
    pagecontent.value = page || null; // Assigning the entire page object or null
    console.log(pagecontent.value?.content);
  }
})


</script>
<script  lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'HsPageView',
  
  data() {
    return {
    }
  },
})
</script>