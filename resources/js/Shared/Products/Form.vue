<script setup>
import { router, useForm } from "@inertiajs/vue3"
import { ref } from "vue"

  let props = defineProps(['product' , 'isUpdate' , 'categories'])

  let imageInput = ref(null)

  let form = useForm({
    _method: props.isUpdate ? 'PATCH' : 'POST' ,
    title: props?.product?.title ?? null ,
    details: props?.product?.details ?? null ,
    price: props?.product?.price ?? null ,
    category_id: props?.product?.category_id ?? null ,
    image: null ,
  })

  let submitForm = () => {

    let url = props.isUpdate ? route( 'products.update' , props?.product?.id)  : route ('products.store'); 
    
    let options =  {
      forceFormData: true ,
      preserveScroll: true ,
      onSuccess: () => {
        form.reset()
        imageInput.value.value = null
      },
    }

    form.post( url , options )
    
  }

  let deleteProduct = () => {
    if( !confirm('Are you sure?')) return
    router.delete( route( 'products.destroy' , props?.product?.id) )
  }
</script>

<template>
  <form @submit.prevent="submitForm" class="grid grid-cols-1 gap-6" enctype="multipart/form-data" >

    <div class="input-style">
      <label for="title">title</label>
      <input type="text" id="title" v-model="form.title">
      <div class="text-red-500" v-if="form.errors.title"> {{ form.errors.title }} </div>
    </div>

    <div class="input-style">
      <label for="details">details</label>
      <textarea  id="details" v-model="form.details"></textarea>
      <div class="text-red-500" v-if="form.errors.details"> {{ form.errors.details }} </div>
    </div>

    <div class="input-style">
      <label for="price">price</label>
      <input type="number" min="0" id="price" v-model="form.price">
      <div class="text-red-500" v-if="form.errors.price"> {{ form.errors.price }} </div>
    </div>

    <div class="input-style">
      <label for="category">category</label>
      <select v-model="form.category_id">
        <option v-for="category , id in categories" :key="id" :value="id"> {{ category }} </option>
      </select>
      <div class="text-red-500" v-if="form.errors.category"> {{ form.errors.category }} </div>
    </div>

    <div class="input-style">
      <label for="image">image</label>
      <input type="file" id="image" @change=" form.image = $event.target.files[0]" ref="imageInput">
      <div class="text-red-500" v-if="form.errors.image"> {{ form.errors.image }} </div>
    </div>

    <div class="flex flex-row justify-self-end gap-5">

      <button @click.prevent="deleteProduct" class=" primary-btn bg-red-500" v-if="isUpdate">delete</button>

      <button type="submit" class=" primary-btn">submit</button>

    </div>


  </form>

  <div v-if="product?.image != false">
    <ImageComponent width="150px" height="200px" :path="product?.image" :alt="product?.title"></ImageComponent>
  </div>
</template>

<style scoped>
  .input-style{
    @apply flex flex-col gap-5
  }
</style>