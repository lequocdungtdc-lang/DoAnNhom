<script setup lang="ts">
import { ref, watchEffect } from 'vue'
import { useRoute } from 'vue-router'
import Header from './components/admin/Header.vue'
import Sidebar from './components/admin/Sidebar.vue'

const route = useRoute()

const user = ref<any>(null)

// 🔥 reactive theo localStorage
watchEffect(() => {
  const userStr = localStorage.getItem('user')

  try {
    user.value = userStr ? JSON.parse(userStr) : null
  } catch {
    user.value = null
  }
})
</script>
<template>
  <!-- 🔓 AUTH -->
  <div v-if="route.meta.layout === 'auth'">
    <router-view />
  </div>

  <!-- 👑 ADMIN -->
  <div v-else-if="route.meta.layout === 'admin'" class="bg-gray-100 dark:bg-black min-h-screen">
    <Header />

    <div class="flex">
      <Sidebar />

      <div class="flex-1 p-4">
        <router-view />
      </div>
    </div>
  </div>

  <!-- 👤 USER -->
  <div v-else class="bg-white dark:bg-black min-h-screen">
    <Header />
    <div class="p-4">
      <router-view />
    </div>
  </div>
</template>