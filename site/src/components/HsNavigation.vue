<template>
  <header>
    <div class="header-wrapper">
      <Transition name="header-main">
        <div v-if="!global.projectViewIsActive" class="mainNavigation">
          <HsNavigationIcon @click="toggleMenue($event, '')" />
        </div>
      </Transition>
      <div class="projectNavigation">
        <div @click="hideProjectView" class="arrow"></div>
        <div @click="hideProjectView" class="link breadCrumb"> {{ global.breadCrumb }}</div>
      </div>
    </div>
    <div class="menue-wrapper flex-spacer">
      <Transition name="fade" @after-leave="onAfterLeave">
        <nav class="navigation" :class="{ active: global.menuIsActive }" v-if="global.menuIsActive">
          <ul class="navigation-list">
            <li class="navigation-list-item" style="transition-delay: 0.2s;">
              <RouterLink @click="toggleMenue($event, 'pinhole')" to="/projects/" class="navigation-link">pinhole
              </RouterLink>
            </li>
            <li class="navigation-list-item" style="transition-delay: 0.2s;">
              <RouterLink @click="toggleMenue($event, 'me')" :to="{ path: '/about', query: { id: '' } }"
                class="navigation-link">me</RouterLink>
            </li>
          </ul>
        </nav>
      </Transition>
    </div>
  </header>
</template>


<script lang="ts" setup>

import { useGlobalStore } from '../stores/global';
import HsNavigationIcon from './HsNavigationIcon.vue';
const global = useGlobalStore()

function toggleMenue(e: MouseEvent, breadcrumb: string) {
  if (e && e.currentTarget instanceof HTMLElement) {
    e.currentTarget.classList.toggle('navigation-clicked');
  }

  if (breadcrumb !== "") {
    global.breadCrumb = breadcrumb
  }
  global.toggle();
}

function hideProjectView() {
  global.projectViewIsActive = false;
  global.subMenuIsActive = true

}

function onAfterLeave() {
  global.setInActive();
  global.subMenuIsActive = true
}

</script>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'HsNavigation',
  data() {
    return {
      id: 'exampleId',
      showMenue: false
    }
  }

})
</script>
