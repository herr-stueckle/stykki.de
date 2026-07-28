
<template>
  <div class="fluid">
    <div id="wrapper">
    <div id="outer">
      <div class="spin-wrap" id="red-spin">
        <div id="red" class="inner redRGB pulse-wrap"></div>
      </div>
      <div class="spin-wrap" id="green-spin">
        <div id="green" class="inner greenRGB pulse-wrap"></div>
      </div>
      <div class="spin-wrap" id="blue-spin">
        <div id="blue" class="inner blueRGB pulse-wrap"></div>
      </div>
      <div id="white" class="inner whiteRGB"></div>
      <div class="center">
        <div id="corona"></div>
        <div id="pinhole"></div>
      </div>
    </div>
  </div>
  </div>
</template>

<script lang="ts" setup>
import axios from 'axios';
import { onMounted } from 'vue';
import { usePages } from '../stores/pages';

import { defineProps } from 'vue';
defineProps({
  id: String
})

const pages = usePages();
const apiURI = process.env.VUE_APP_API_URL;

import { useGlobalStore } from "../stores/global";
const global = useGlobalStore();

onMounted(() => {
  axios.get(`${apiURI}/cms/api/pages.php`, {
    headers: {
      "Cache-Control": "no-cache",
      "Content-Type": "application/x-www-form-urlencoded",
      "Access-Control-Allow-Origin": "*",
    }
  }).then((response) => {
    pages.init(response.data);
    global.setColorTheme('black')

  }).catch((error) => {
    console.error("There was an error!", error);
  });
});
</script>


<script  lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'HsAboutView',
  
  data() {
    return {
    }
  },
})
</script>

<style>
#wrapper {
      width: 100vw;
      position: relative;
      left: 50%;
      margin-left: -50vw;
      margin-right: -50vw;
      height: calc(100vh - 72px - 36px);
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: rgb(0, 0, 0);
      border-top: 1px solid #ffffff;
    }

    .redRGB {
      background-image: radial-gradient(in oklch circle at center, rgba(255, 0, 0, 1) 0%, transparent 70%);
    }

    .greenRGB {
      background-image: radial-gradient(in oklch circle at center, rgba(0, 255, 0, 1) 0%, transparent 70%);
    }

    .blueRGB {
      background-image: radial-gradient(in oklch circle at center, rgba(0, 0, 255, 1) 0%, transparent 70%);
    }

    .whiteRGB {
      background-image: radial-gradient(in oklch circle at center, rgba(255, 255, 255, 1) 0%, rgba(255, 255, 255, 0) 60%);
    }

    .inner {
      height: 70%;
      aspect-ratio: 1 /1;
    }

    #outer {
      position: relative;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 90%;
      aspect-ratio: 1 / 1;

    }

    #corona {
      position: absolute;
      background-color: rgba(255, 255, 255, 1);
      border-radius: 50%;
      width: 25px;
      height: 25px;
      mix-blend-mode: plus-lighter;
      filter: blur(25px);

    }

    #pinhole {
      background-color: rgba(0, 0, 0, 1);
      width: 3px;
      height: 3px;
      border-radius: 50%;

    }

    #white {
      height: 400px;
      opacity: 0.6;
      mix-blend-mode: plus-lighter;
      animation: pulse-white 3s linear infinite;
      filter: blur(60px);
    }

    #red {
      position: absolute;
      left: 0;
      mix-blend-mode: plus-lighter;
      transform-origin: calc(50% + 21.43%) 50%;

    }

    #green {
      right: 0;
      position: absolute;
      mix-blend-mode: plus-lighter;
      transform-origin: calc(50% - 21.43%) 50%;
    }

    #blue {
      position: absolute;
      bottom: 0;
      mix-blend-mode: screen;
      transform-origin: 50% calc(50% - 21.43%)
    }

    .spin-wrap {
      position: absolute;
      height: 70%;
      aspect-ratio: 1 / 1;
      mix-blend-mode: screen;
      animation: spin 3s linear infinite;
    }

    #red-spin {
      left: 0;
      transform-origin: calc(50% + 21.43%) 50%;
    }

    #green-spin {
      right: 0;
      transform-origin: calc(50% - 21.43%) 50%;
    }

    #blue-spin {
      bottom: 0;
      transform-origin: 50% calc(50% - 21.43%);
    }

    /* remove position/mix-blend-mode from the inner IDs — they're now plain containers */
    #red,
    #green,
    #blue {
      position: static;
      mix-blend-mode: normal;
    }

    .pulse-wrap {
      animation: pulse 1.4s ease-in-out infinite;
      width: 100%;
      height: 100%;
    }

    .center {
      position: absolute;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    #red.pulse-wrap {
      animation-delay: 0s;
    }

    #green.pulse-wrap {
      animation-delay: 0s;
    }

    #blue.pulse-wrap {
      animation-delay: 0s;
    }

    @keyframes spin {
      to {
        transform: rotate(360deg);
      }
    }

    @keyframes pulse {

      0%,
      100% {
        transform: scale(1);
      }

      50% {
        transform: scale(0.8);
      }
    }

    @keyframes pulse-white {

      0%,
      100% {
        transform: scale(0.8);
      }

      50% {
        transform: scale(1);
      }
    }

    .hero-image-wrapper {
      position: absolute;
      padding: 0 0;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 0;
    }

    .hero-image-wrapper img {
      object-fit: cover;
      width: 100%;
      height: 100%;
    }
</style>