<template>
  <header>
    <div class="header-wrapper">
      <Transition name="header-main">
        <div v-if="!global.projectViewIsActive" class="mainNavigation">
          <div class="NavIconContainer">
            <RouterLink v-if="$route.path !== '/'" to="/" class="link breadCrumb">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="30px"
                height="30px">
                <path
                  d="M 12 2 A 1 1 0 0 0 11.289062 2.296875 L 1.203125 11.097656 A 0.5 0.5 0 0 0 1 11.5 A 0.5 0.5 0 0 0 1.5 12 L 4 12 L 4 20 C 4 20.552 4.448 21 5 21 L 9 21 C 9.552 21 10 20.552 10 20 L 10 14 L 14 14 L 14 20 C 14 20.552 14.448 21 15 21 L 19 21 C 19.552 21 20 20.552 20 20 L 20 12 L 22.5 12 A 0.5 0.5 0 0 0 23 11.5 A 0.5 0.5 0 0 0 22.796875 11.097656 L 12.716797 2.3027344 A 1 1 0 0 0 12.710938 2.296875 A 1 1 0 0 0 12 2 z" />
              </svg>
            </RouterLink>
          </div>
          <div>
            <HsNavigationIcon @click="toggleMenue($event, '')" />
          </div>

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
              <RouterLink @click="toggleMenue($event, 'me')" :to="{ path: '/about', query: { id: 'me' } }"
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
