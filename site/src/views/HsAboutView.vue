
<template>
  <div>
    User {{ userId }}
  </div>  
</template>

<script lang="ts" setup>
import { defineProps } from 'vue';
import { useRoute } from 'vue-router';
defineProps({
  id: String
})

const route = useRoute();
const userId = route.query.id; // Accessing the query parameter 'id'

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