
<template>
    <HsNavigation />
    <RouterView  class="flex-spacer"/>
    <HsFooter class="footer"/>

</template>

<script lang="ts" setup>
import HsFooter from './components/HsFooter.vue';
import HsNavigation from './components/HsNavigation.vue';
</script>

<script lang="ts">
import { defineComponent } from 'vue';


export default defineComponent({
  name: 'App',
  data(){
    return{
       apiURI: process.env.VUE_APP_API_URL
    }
  },

});
</script>