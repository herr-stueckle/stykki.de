
<template>
  <div class="project-wrapper fluid">
    r_d_c_ t_ th_ m_x
  </div>
</template>

<script lang="ts" setup>
import axios from 'axios';
import { onMounted } from 'vue';
import { usePages } from '../stores/pages';

import { defineProps } from 'vue';
defineProps({
  id: String
})

const pages = usePages();
const apiURI = process.env.VUE_APP_API_URL;

onMounted(() => {
  axios.get(`${apiURI}/cms/api/pages.php`, {
    headers: {
      "Cache-Control": "no-cache",
      "Content-Type": "application/x-www-form-urlencoded",
      "Access-Control-Allow-Origin": "*",
    }
  }).then((response) => {
    pages.init(response.data);

  }).catch((error) => {
    console.error("There was an error!", error);
  });
});
</script>


<script  lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'HsAboutView',
  
  data() {
    return {
    }
  },
})
</script>