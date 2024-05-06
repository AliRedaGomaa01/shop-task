<script setup>
  import { usePage } from "@inertiajs/vue3";

  let trans = usePage().props.trans;
  let langLink = usePage().props.langLink;
  
</script>

<template>
    
    <Layout>
      <div class="p-10 flex flex-col gap-10">
        <div>
            <div class="text-3xl text-center">{{ trans['test'] }}</div>
        </div>

        <div class="grid grid-cols-2 place-items-center ">
          <Link :href="langLink['ar']" as='button' class="primary-btn" >
            العربية
          </Link>

          <Link :href="langLink['en']" as='button' class="primary-btn" >
            English
          </Link>
        </div>
      </div>
    </Layout>
</template>