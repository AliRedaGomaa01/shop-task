<script setup>
import Form from '@/Shared/Products/Form.vue';

let props = defineProps([  'product' , 'categories'])

</script>

<template>
  <Head title="Edit" />

    <Layout>
      <div class="flex flex-col gap-5 w-[60vw]">
        <h1 class="text-3xl text-center">Edit</h1>
        
        <Form :isUpdate="true" :categories="categories" :product="product" />
      </div>
    </Layout>
    
</template>