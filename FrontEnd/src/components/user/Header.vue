<script setup lang="ts">
import { useRouter } from 'vue-router'
import { ref, onMounted } from 'vue'
import { getProfile } from '../../services/auth'

interface User {
  id: number
  fullname?: string
  email: string
}

const router = useRouter()
const user = ref<User | null>(null)
const isDark = ref(false)

// 🔥 apply theme
function applyTheme(theme: 'dark' | 'light') {
  const html = document.documentElement

  if (theme === 'dark') {
    html.classList.add('dark')
    isDark.value = true
  } else {
    html.classList.remove('dark')
    isDark.value = false
  }

  localStorage.setItem('theme', theme)
}

// 🌙 toggle
function toggleTheme() {
  applyTheme(isDark.value ? 'light' : 'dark')
}

// 🔐 logout
function logout() {
  localStorage.removeItem('token')
  user.value = null
  router.push('/login')
}

// 👤 load profile
async function fetchProfile() {
  try {
    const res = await getProfile()
    user.value = (res.data as any).data || res.data
  } catch {
    logout()
  }
}

onMounted(() => {
  // 🔥 load theme (ưu tiên localStorage)
  const saved = localStorage.getItem('theme') as 'dark' | 'light' | null

  if (saved) {
    applyTheme(saved)
  } else {
    // fallback theo hệ điều hành
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches
    applyTheme(prefersDark ? 'dark' : 'light')
  }

  // 🔥 load user
  if (localStorage.getItem('token')) {
    fetchProfile()
  }
})
</script>

<template>
  <nav class="px-6 py-3 flex items-center justify-between border-b transition
           bg-white text-black border-gray-200
           dark:bg-[#0f0f0f] dark:text-gray-200 dark:border-gray-800">

    <!-- Logo -->
    <div class="font-medium tracking-tight">
      User Panel
    </div>

    <!-- Right -->
    <div class="flex items-center gap-3 text-sm">

      <!-- 🌙 Toggle -->
      <button @click="toggleTheme" class="px-2 py-1 rounded-md border border-gray-300
               hover:bg-gray-100 transition
               dark:border-gray-700 dark:hover:bg-gray-800">
        {{ isDark ? '🌙' : '☀️' }}
      </button>

      <!-- User -->
      <template v-if="user">
        <span class="text-gray-600 dark:text-gray-400">
          {{ user.fullname || user.email }}
        </span>

        <button @click="logout" class="bg-black text-white px-3 py-1.5 rounded-md hover:opacity-80
                 dark:bg-white dark:text-black transition">
          Logout
        </button>
      </template>

      <!-- Guest -->
      <template v-else>
        <button @click="router.push('/login')" class="bg-black text-white px-3 py-1.5 rounded-md hover:opacity-80
                 dark:bg-white dark:text-black transition">
          Login
        </button>
      </template>

    </div>
  </nav>
</template>