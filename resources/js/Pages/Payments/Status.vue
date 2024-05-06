<script setup>
  defineProps({
    status: {
      type: String,
      default : 'pending'
    }
  })
</script>

<template>
    <Layout>
      Payment {{ status }}
    </Layout>
</template>