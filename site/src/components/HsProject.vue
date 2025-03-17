<template>
  <div class="frame" v-if="!global.subMenuIsActive">
    <HsImage :image="projectImages[0]"/>
  </div>
</template>

<script lang="ts" setup>
import { defineProps, onBeforeMount, ref, withDefaults } from 'vue';
import { useGlobalStore } from '../stores/global';
import { usePhotoProjects } from '../stores/photoProjects';
import HsImage from "./HsImage.vue";

const global = useGlobalStore();

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
  id?: number;
}

const props = withDefaults(defineProps<Props>(), {
  id: 0,
});

// Reactive object to hold project details
const projectName = ref<string>('');
const projectImages = ref<Image[]>([]);

const photoProjectList = usePhotoProjects();

onBeforeMount(() => {
  if (props.id >= 0 && props.id < photoProjectList.projectList.length) {
    const project = photoProjectList.projectList[props.id];

    // Zuweisen des Projektnamens
    projectName.value = project.name;

    // Parsing des JSON-Strings in ein Array von Objekten
    try {
      projectImages.value = JSON.parse(project.images); // Convert the string to an array
    } catch (error) {
      console.error("Failed to parse project images:", error);
      projectImages.value = []; // Set to empty array on error
    }

    console.log(Array.isArray(projectImages.value)); // Überprüfen, ob jetzt ein Array ist
    console.log(photoProjectList.projectList[props.id].pro_ratio);
  }
});
</script>