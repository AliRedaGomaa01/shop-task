<script setup>
import ProductCard from '@/Shared/Products/ProductCard.vue';

let props = defineProps(['products'])

</script>

<template>

  <Head title="Products" />
  
  <Layout>
    <template #header2>
      Products
    </template>

    <div class="flex flex-row flex-wrap  gap-10  place-items-center">
      <p v-if="!products.length">There are no products.</p>
      <template v-if="products.length">
          <ProductCard v-for="product in products" :key="product.id" :product="product" class=" mx-auto"/>
      </template>
    </div>
  </Layout>
</template>