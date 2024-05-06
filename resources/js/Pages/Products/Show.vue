<script setup>
import { useForm } from "@inertiajs/vue3"

  
  let props = defineProps(['product'])
  
  let form = useForm({
    _method: 'POST',
    quantity: 1,
    product_id: props.product.id,
    amount: props.product.price
  })
  let buyProduct = () => {
    form.post(route('payments.checkout') )
  }
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
          
          <div class="flex flex-row justify-self-end gap-5">
            <input type="number" min="0" v-model="form.quantity">
            
            <button @click="buyProduct" class="primary-btn">Buy</button>
          </div>

        </div>
      </div>

  </Layout>
</template>