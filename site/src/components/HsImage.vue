<template>
    <img :src="apiURI +'cms/' + image.img_folder + image.img_path" alt="">
</template>

<script lang="ts" setup>
import { defineProps, withDefaults } from 'vue';

interface Image {
  img_date: string;
  img_name: string;
  img_path: string;
  img_width: number;
  img_folder: string;
  img_height: number;
  img_name_en: string;
  img_description: string;
  img_thumb_folder: string;
  img_description_en: string;
}

interface Props {
  image: Image;
}

const apiURI = process.env.VUE_APP_API_URL;
console.log(apiURI)

// Default values for the image prop must be provided via a function
const props = withDefaults(defineProps<Props>(), {
  image: () => ({
    img_date: "0",
    img_name: "",
    img_path: "",
    img_width: 0,
    img_folder: "",
    img_height: 0,
    img_name_en: "",
    img_description: "",
    img_thumb_folder: "",
    img_description_en: "",
  })
});
</script>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'HsImage',
});
</script>