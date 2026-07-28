
<template>
  <div class="">
   
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
import { ref, watch } from 'vue';
import { useRoute } from 'vue-router';
import { usePages } from '../stores/pages';

console.log('script setup running'); // add this too, temporarily

const route = useRoute();
const pages = usePages();
const pagecontent = ref(null);

watch(
  () => route.query.id,
  (newId) => {
    
    pagecontent.value = newId ? pages.getPage(newId as string) || null : null;
    console.log(pagecontent);
  },
  { immediate: true }
);
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