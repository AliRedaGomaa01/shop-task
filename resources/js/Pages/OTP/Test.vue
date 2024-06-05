<script setup>
import { router, useForm } from "@inertiajs/vue3"

  let props = defineProps({
    isSent : {
      type: Boolean,
      default: false
    }
  })

  let form = useForm({
    'otp' : null
  })
</script>

<template>
  <Head title="OTP Test"></Head>
    <Layout>
      <div v-if="!isSent" class="flex place-content-center" >
        <button class="primary-btn mx-auto" @click="router.get(route('otp.send'))">Send OTP</button>
      </div>

      <form @submit.prevent="form.post(route('otp.check'))" v-if="isSent"
      class="grid grid-cols-1 gap-6">

        <div class="input-style">
          <label for="otp">otp</label>
          <input type="text" id="otp" v-model="form.otp">
          <div class="text-red-500" v-if="form.errors.otp"> {{ form.errors.otp }} </div>
        </div>

        <div class="flex flex-row justify-self-end gap-5">
          <button type="submit" class=" primary-btn">submit</button>
        </div>
      </form>
    </Layout>
</template>

<style scoped>
  .input-style{
    @apply flex flex-col gap-5
  }
</style>