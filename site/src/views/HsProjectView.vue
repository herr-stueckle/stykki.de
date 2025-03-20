<template>
  <div v-if="!global.menuIsActive" >
    <Transition name="subMenue" @after-leave="onAfterLeave">
      <div v-if="global.subMenuIsActive" style="margin-top: 12px;margin-left: 24px;">
        <div v-for="(project, index) in photoProjectList.projectList" :key="index" class="link-black"
          @click="setProject(index, $event)">
          {{ project.name }}
        </div>
      </div>
    </Transition>
    <div class="project-wrapper" v-if="global.projectViewIsActive">
      <HsProject :id="selectedProject"  />
    </div>
  </div>
</template>

<script lang="ts" setup>
import axios from 'axios';
import { onMounted, ref } from 'vue';
import HsProject from '../components/HsProject.vue';
import { usePhotoProjects } from '../stores/photoProjects';

import { useGlobalStore } from '../stores/global';
const global = useGlobalStore()

const photoProjectList = usePhotoProjects();
const apiURI = process.env.VUE_APP_API_URL;

const menue = ref(true);
const content = ref(false);
const selectedProject = ref(-1);

function onAfterLeave(){
  global.projectViewIsActive = true
  content.value = true
}

onMounted(() => {
  axios.get(`${apiURI}/cms/api/projects.php`, {
    headers: {
      "Cache-Control": "no-cache",
      "Content-Type": "application/x-www-form-urlencoded",
      "Access-Control-Allow-Origin": "*",
    }
  }).then((response) => {
    if (photoProjectList.projectList.length === 0) {
      photoProjectList.init(response.data);
    }

  }).catch((error) => {
    console.error("There was an error!", error);
  });
});


function setProject(id: number, e:MouseEvent) {
  if (e && e.currentTarget instanceof HTMLElement) {
    e.currentTarget.classList.toggle('test');
  }

  selectedProject.value = id;
  global.currentPage = photoProjectList.projectList[id].name;
  photoProjectList.currentSlide=-1

  menue.value = false;
  global.subMenuIsActive = false
  
}
</script>