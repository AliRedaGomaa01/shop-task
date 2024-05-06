<script setup>
  let props = defineProps(['height', 'width', 'path', 'alt'])
</script>

<template>
  <div :class="`w-[${width}] h-[${height}] overflow-hidden grid place-items-center` ">
    <img :src="path" :alt="alt" :class="`max-w-[${width}] max-h-[${height}]`" >
  </div>
</template>