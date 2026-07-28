<template>
  <div v-html="pagecontent?.content" class="page-text">
  </div>
</template>

<script lang="ts" setup>
import { ref, watch } from "vue";
import { useRoute } from "vue-router";
import { usePages } from "../stores/pages";

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

<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
  name: "HsPageView",

  data() {
    return {};
  },
});
</script>

<style >
  .page-text{
    min-height: calc(70vh - 36px - 72px);
    /* display: flex; */
    padding: 5%;
    font-size: 16px;
    font-weight: 300;
    cursor: pointer;
    max-width: 1280px;
  }
</style>
