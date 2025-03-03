
<script setup lang="ts">
import { createApp } from 'vue';
import HsSlide from './components/HsSlide.vue';

const app = createApp({})

app.component(
  // the registered name
  'App',
  // the implementation
  {
    /* ... */
  }
)

</script>

<template>
    <HsSlide msg="Tach"/>
</template>

<style>
</style>
