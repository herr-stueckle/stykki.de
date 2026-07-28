<template>
<div class="image">
  <img ref="img" >
  <div :class="props.ratio +'ImageTitle'" ref="title">{{ props.image.img_name }} | <span class="imageDate">{{ props.image.img_date }}</span></div>
</div>
    

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
  ratio?: string
}

const apiURI = process.env.VUE_APP_API_URL;


const photoProjectList = usePhotoProjects();
const img = ref<HTMLImageElement | null>(null);
const title = ref<HTMLImageElement | null>(null);

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
  ratio:''
});

defineExpose({
  triggerAnimation
});

onMounted(()=>{
  const imageSrc = `${apiURI}/cms/${props.image.img_folder}/${props.image.img_path}`;

    
  const preload = new Image();
  preload.src = imageSrc;

  preload.onload = () => {
    if (img.value) {
      img.value.src = preload.src;
      img.value.classList.add(props.ratio + "TransitionIn");

    }
  };

  // optional: für den Fall, dass das Bild nicht geladen werden kann
  preload.onerror = () => {
    console.error('Bild konnte nicht geladen werden:', preload.src);
  };

  setTimeout(()=>{
    title.value?.classList.add('imageTitleShow')
  }, 500)

})

function triggerAnimation (){
  if(img.value?.classList.contains(props.ratio + "TransitionIn")){
    img.value?.classList.remove(props.ratio + "TransitionIn")
    title.value?.classList.remove('imageTitleShow')
    img.value?.classList.add(props.ratio + "TransitionOut")
  }
  else{
    img.value?.classList.add(props.ratio + "TransitionIn")
  }
  if(props.ratio ==="panorama"){
    setTimeout(()=>{
    photoProjectList.currentSlide++
  }, 1000)
  }

  if(props.ratio ==="circle"){
    setTimeout(()=>{
    photoProjectList.currentSlide++
  }, 1500)
    
  }




  
  
  
}


</script>

<script lang="ts">
import { defineComponent, onMounted } from 'vue';

export default defineComponent({
  name: 'HsImage',
});
</script>

<style lang="scss">

.image{
  position:relative;
}

.buttons{
  display: flex;
  width: 100%;
  padding-left:24px;
  justify-content: flex-end;
  position:absolute;
  bottom:-80px;
}

.panoramaImageTitle{
  margin-top: 6px;
  font-size: 14px;
  font-weight: 900;
  opacity: 0;
  transition: all 1s;
  text-align: right;
  margin-right: 25%;
  border-top: 1px solid #000;
}

.circleImageTitle{
  border-top: 1px solid #000;
  margin-top: 6px;
  font-size: 14px;
  font-weight: 900;
  opacity: 0;
  transition: all 1s;
  text-align: right;
  margin-right: 25%;
}

.imageDate{
  font-size: 14px;
  font-weight: 200;
}
.imageTitleShow {
  opacity: 1;
  margin-right: 0px;
}


.panoramaTransitionIn{
  animation: 1s panoramaIn forwards ease-in-out;
}

.panoramaTransitionOut{
  animation: 1s panoramaOut forwards ease-in-out;
}

@keyframes panoramaIn {
  0% { clip-path: polygon(0% 0%, 0% 0%, 0% 100%, 0 100%); }
  100% { clip-path: polygon(0% 0%, 100% 0%, 100% 100%, 0% 100%); }
}

@keyframes panoramaOut {
  0% { clip-path: polygon(0% 0%, 100% 0%, 100% 100%, 0% 100%); }
  100% { clip-path: polygon(75% 0%, 75% 0%, 75% 100%, 75% 100%);  }
}



.circleTransitionIn{
  animation: 1s circleIn forwards ease-in-out;
}

.circleTransitionOut{
  animation: 1s circleOut forwards ease-in-out;
}

@keyframes circleIn {
  0% { clip-path: circle(0% at 50% 50%);}
  100% { clip-path: circle(100% at 50% 50%);}
}

@keyframes circleOut {
  0% { clip-path: circle(100% at 50% 50%); }
  100% { clip-path: circle(0% at 50% 50%); }
}



</style>