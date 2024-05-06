<script setup>
import { router, useForm } from "@inertiajs/vue3"
import { ref } from "vue"

  let form = useForm({
    title:   null ,
    details:  null ,
  })

  let submitForm = () => {

    let url = route('categories.store'); 
    
    let options =  {
      preserveScroll: true ,
      onSuccess: () => {
        form.reset()
      },
    }

    form.post( url , options )
    
  }
</script>

<template>
  <Head title="Create" />

    <Layout>
      <div class="flex flex-col gap-5 w-[60vw]">
        <h1 class="text-3xl text-center">Create</h1>
        
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

          <div class="flex flex-row justify-self-end gap-5">

            <button type="submit" class=" primary-btn">submit</button>

          </div>
        </form>
      </div>
    </Layout>
    
</template>

<style scoped>
  .input-style{
    @apply flex flex-col gap-5
  }
</style>