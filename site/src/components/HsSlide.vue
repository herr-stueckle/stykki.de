
<template>
  <button v-on:click="clieded">{{props.msg}} {{count }}</button>
</template>




<script lang="ts" setup>
import { defineProps, ref, withDefaults } from 'vue';

interface Props {
  msg?: string
  labels?: string[]
}

const props = withDefaults(defineProps<Props>(), {
  msg: 'hello',
  labels: () => ['one', 'two']
})

const count = ref(1)

function clieded(){
  count.value++
}

</script>

<script  lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  data() {
    return {
      count: 1
    }
  }
})
</script>

