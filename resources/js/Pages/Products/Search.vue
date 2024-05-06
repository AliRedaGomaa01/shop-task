<script setup>
import SearchForm from '@/Shared/Products/SearchForm.vue';

let props = defineProps(['categories'])

</script>

<template>
  <Head title="Search" />

    <Layout>
      <div class="flex flex-col gap-5 w-[60vw]">
        <h1 class="text-3xl text-center">Search</h1>
        
        <SearchForm :categories="categories" />
      </div>
    </Layout>
    
</template>