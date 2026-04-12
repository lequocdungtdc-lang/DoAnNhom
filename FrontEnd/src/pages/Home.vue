<script setup lang="ts">
import { useRoute } from 'vue-router'
import { onMounted } from 'vue'
import { useToast } from 'vue-toastification'

const route = useRoute()

onMounted(() => {
   if (route.query.error === 'forbidden') {
      useToast().error('Bạn không có quyền truy cập')
   }
})
</script>

<template>
  <div class="container mt-5">
    <h1 class="text-primary">Vue + Bootstrap 😎</h1>
    <button class="btn btn-success">Click me</button>
  </div>
</template>