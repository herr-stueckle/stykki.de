<template>
  <div v-if="!global.menuIsActive" >
    <Transition name="subMenue" @after-leave="() => { global.subMenuIsActive = false; content = true }">
      <div v-if="global.subMenuIsActive" style="margin-top: 12px;margin-left: 24px;">
        <div v-for="(project, index) in photoProjectList.projectList" :key="index" class="link-black"
          @click="setProject(index, $event)">
          {{ project.name }}
        </div>
      </div>
    </Transition>
    <div class="project-wrapper" v-if="!global.subMenuIsActive">
      <HsProject :id="selectedProject" class="image-frame" />
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


function resetProjectView() {
  global.subMenuIsActive = true
  global.projectViewIsActive = false
  content.value = false;
  menue.value = true;
}

function setProject(id: number, e:MouseEvent) {
  if (e && e.currentTarget instanceof HTMLElement) {
    e.currentTarget.classList.toggle('test');
  }

  selectedProject.value = id;
  global.currentPage = photoProjectList.projectList[id].name;




  menue.value = false;
  global.subMenuIsActive = false
  global.projectViewIsActive = true
}
</script>