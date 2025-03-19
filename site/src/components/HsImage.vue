<template>

    <img class="imageTransitionPanorama" ref="img" >

</template>

<script lang="ts" setup>
import { defineExpose, defineProps, ref, withDefaults } from 'vue';
import { usePhotoProjects } from '../stores/photoProjects';

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
  image: Image,
  id?: number;
}

const apiURI = process.env.VUE_APP_API_URL;


const photoProjectList = usePhotoProjects();
const img = ref<HTMLImageElement | null>(null);

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
  }),
  id:0,
});

defineExpose({
  triggerAnimation
});

onMounted(()=>{
  const imageSrc = `${apiURI}cms/${props.image.img_folder}${props.image.img_path}`;
    
  const preload = new Image();
  preload.src = imageSrc;

  preload.onload = () => {
    if (img.value) {
      img.value.src = preload.src;
      img.value.classList.add("imageTransitionPanoramaIn");
    }
  };

  // optional: für den Fall, dass das Bild nicht geladen werden kann
  preload.onerror = () => {
    console.error('Bild konnte nicht geladen werden:', preload.src);
  };

})

function triggerAnimation (){
  if(img.value?.classList.contains('imageTransitionPanoramaIn')){
    img.value?.classList.remove('imageTransitionPanoramaIn')
    img.value?.classList.add('imageTransitionPanoramaOut')
  }
  else{
    img.value?.classList.add('imageTransitionPanoramaIn')


  }
  setTimeout(()=>{
    photoProjectList.currentSlide++
  }, 1000)
  
 //img.value?.classList.add("imageTransitionPanoramaIn")
  //
  //photoProjectList.currentSlide = props.id
  
}


</script>

<script lang="ts">
import { defineComponent, onMounted } from 'vue';

export default defineComponent({
  name: 'HsImage',
});
</script>

<style lang="scss">
.imageTransitionPanorama{
}

.imageTransitionPanoramaIn{
  animation: 1s panoramaIn forwards;
}

.imageTransitionPanoramaOut{
  animation: 1s panoramaOut forwards;
}

@keyframes panoramaIn {
  0% { clip-path: polygon(25% 0%, 0% 0%, 0% 100%, 25% 100%); }
  100% { clip-path: polygon(0% 0%, 100% 0%, 100% 100%, 0% 100%); }
}

@keyframes panoramaOut {
  0% { clip-path: polygon(0% 0%, 100% 0%, 100% 100%, 0% 100%); }
  100% { clip-path: polygon(75% 0%, 75% 0%, 75% 100%, 75% 100%);  }
}

</style>