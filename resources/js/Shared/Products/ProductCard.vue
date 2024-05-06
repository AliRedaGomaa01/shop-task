<script setup>
  let props = defineProps(['product'])
</script>

<template>
  <div class="bg-white shadow-lg rounded-lg flex flex-col gap-5 place-items-center text-center p-5">
    
    <Link :href="route('products.show', product.id)" preserve-scroll >

        <div class="text-2xl border-b-2 py-2" v-if="product?.title"> {{ product?.title }}  </div>

        <div class="text-2xl border-b-2 py-2" v-if="product?.category?.title"> {{ product?.category?.title }}  </div>

        <div class="border-b-2 py-2" v-if="product?.image != false">
          <ImageComponent width="150px" height="200px" :path="product?.image" :alt="'product image'"  ></ImageComponent>
        </div>

        <div class=" "> {{ product?.price }} </div>

    </Link>
    
  </div>
</template>