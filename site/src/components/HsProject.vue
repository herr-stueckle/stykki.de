<template>
  <div v-if="id >= 0 && photoProjectList.currentSlide === -1" class="project-wrapper text-left">
    <div
      v-html="projectDescription"
      class="intro"
      :class="projectRatio + 'TextFrame'"
      @click="nextSlide"
    ></div>
  </div>
    <div class="project-wrapper image-center">

<HsImage
      ref="imageComponent"
      v-if="
        projectImages.length > 0 &&
        photoProjectList.currentSlide >= 0 &&
        photoProjectList.currentSlide < projectImages.length
      "
      :id="photoProjectList.currentSlide"
      :key="photoProjectList.currentSlide"
      :image="projectImages[photoProjectList.currentSlide]"
      :ratio="projectRatio"
      @click="nextSlide"
      class="image-frame image"
      :class="projectRatio"
    />
    </div>

    
</template>

<script lang="ts" setup>
import { defineProps, onBeforeMount, ref, withDefaults } from "vue";
import { usePhotoProjects } from "../stores/photoProjects";
import HsImage from "./HsImage.vue";

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

const props = withDefaults(defineProps<Props>(), { id: -1 });
const projectDescription = ref<string>("");
const projectRatio = ref<string>("");
const projectImages = ref<Image[]>([]);
const photoProjectList = usePhotoProjects();
const imageComponent = ref(null);

function nextSlide() {
  
  if (photoProjectList.currentSlide == -1) {
    photoProjectList.currentSlide = 0;
  }
  else if(photoProjectList.currentSlide < projectImages.value.length-1){
    imageComponent.value?.triggerAnimation();
  }
  else{
    photoProjectList.currentSlide = -1
  }
  
}

onBeforeMount(() => {
  if (props.id >= 0 && props.id < photoProjectList.projectList.length) {
    const project = photoProjectList.projectList[props.id];
    projectDescription.value = project.description;
    projectRatio.value = project.pro_ratio

    try {
      projectImages.value = JSON.parse(project.images);
    } catch (error) {
      console.log(error)
      projectImages.value = [];
    }
  }
});
</script>

<style lang="scss">


.panoramaTextFrame {
   max-width:1024px;

}


.circleTextFrame {
 max-width:1024px;

}




</style>