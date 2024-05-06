<script setup>
import { router, useForm } from "@inertiajs/vue3"
import { ref } from "vue"

  let props = defineProps(['categories'])

  let imageInput = ref(null)

  let form = useForm({
    title: null ,
    details:  null ,
    minPrice:  null ,
    maxPrice:  null ,
    category_id:  null ,
  })

  let submitForm = () => {

    let url = route('products.search.result'); 
    
    let options =  {
      forceFormData: true ,
      preserveScroll: true ,
      onSuccess: () => {
        form.reset()
      },
    }

    form.post( url , options )
    
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
      <label for="minPrice">minPrice</label>
      <input type="number" min="0" id="minPrice" v-model="form.minPrice">
      <div class="text-red-500" v-if="form.errors.minPrice"> {{ form.errors.minPrice }} </div>
    </div>

    <div class="input-style">
      <label for="maxPrice">maxPrice</label>
      <input type="number" min="0" id="maxPrice" v-model="form.maxPrice">
      <div class="text-red-500" v-if="form.errors.maxPrice"> {{ form.errors.maxPrice }} </div>
    </div>

    <div class="input-style">
      <label for="category">category</label>
      <select v-model="form.category_id">
        <option v-for="category , id in categories" :key="id" :value="id"> {{ category }} </option>
      </select>
      <div class="text-red-500" v-if="form.errors.category"> {{ form.errors.category }} </div>
    </div>

    <div class="flex flex-row justify-self-end gap-5">

      <button type="submit" class=" primary-btn">Search</button>

    </div>

  </form>

</template>

<style scoped>
  .input-style{
    @apply flex flex-col gap-5
  }
</style>