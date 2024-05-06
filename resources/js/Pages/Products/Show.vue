<script setup>
  
  let props = defineProps(['product'])
  
</script>

<template>

  <Head title="Product" />

  <Layout>

    <template #header2>
      Product
    </template>

      <div class="grid grid-cols-1 lg:grid-cols-2 place-items-center gap-5 w-[80vw]">

        <!-- product images -->
        <div class="flex " v-if="product?.image != false">
            <a :href="product.image" v-if="product.image" target="_blank">
              <ImageComponent width="150px" height="200px" :path="product.image" :alt="product.title" />
            </a>
        </div>

        <!-- product details -->
        <div class="flex flex-col gap-5 text-center ">

          <h2 class="text-3xl ">{{ product.title }}</h2>
          <h3 class="text-2xl ">{{ product?.category?.title }}</h3>
          <p class="text-xl ">{{ product.price }}</p>
          <p class="text-xl ">{{ product.details }}</p>
          
        </div>
      </div>
  </Layout>
</template>