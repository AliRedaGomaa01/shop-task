<script setup>
import Form from '@/Shared/Products/Form.vue';

let props = defineProps(['categories'])

</script>

<template>
  <Head title="Create" />

    <Layout>
      <div class="flex flex-col gap-5 w-[60vw]">
        <h1 class="text-3xl text-center">Create</h1>
        
        <Form :isUpdate="false" :categories="categories" />
      </div>
    </Layout>
    
</template>