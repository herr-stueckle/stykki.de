<template>
  <footer :class="`footer-${colorTheme}`">
    
  </footer>
</template>


<script lang="ts" setup>



</script>

<script lang="ts" setup>
import { defineComponent } from 'vue';
import { useGlobalStore } from "../stores/global";
import { storeToRefs } from "pinia";
const global = useGlobalStore();
const { colorTheme } = storeToRefs(global);
</script>

<script lang="ts">
export default defineComponent({
  name: 'HsFooter',
  data() {
    return {
    }
  }

})
</script>

