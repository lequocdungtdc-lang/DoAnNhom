<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { login as loginApi } from '../services/auth'

const email = ref('admin@gmail.com')
const password = ref('123456')
const router = useRouter()

const error = ref<string>('')
const loading = ref<boolean>(false)

async function login() {
   error.value = ''
   loading.value = true

   try {
      const res = await loginApi({
         email: email.value,
         password: password.value,
      })

      const { token, user } = res.data

      // ❌ nếu backend lỗi format
      if (!token || !user) {
         error.value = '❌ Dữ liệu trả về không hợp lệ'
         return
      }

      // ✅ lưu
      localStorage.setItem('token', token)
      localStorage.setItem('user', JSON.stringify(user))

      // 🔥 redirect (dùng replace tránh back về login)
      if (user.role === 'admin') {
         router.replace('/admin')
      } else {
         router.replace('/') // 👈 nên rõ ràng luôn
      }

   } catch (err: any) {
      const status = err.response?.status

      if (status === 422) {
         error.value = '❌ Thiếu email hoặc password'
      } else if (status === 401) {
         error.value = '❌ Sai tài khoản hoặc mật khẩu'
      } else if (err.message === 'Network Error') {
         error.value = '❌ Không kết nối được server'
      } else {
         error.value =
            err.response?.data?.message || '❌ Có lỗi xảy ra'
      }
   } finally {
      loading.value = false
   }
}
</script>



<template>
   <div class="min-h-screen flex items-center justify-center
              bg-gradient-to-br from-[#0b0b0b] via-[#111] to-[#1a1a1a]">

      <div class="w-full max-w-sm p-6 rounded-2xl
                border border-white/10 bg-white/5 backdrop-blur
                shadow-[0_10px_40px_rgba(0,0,0,0.6)]">

         <!-- Title -->
         <h3 class="text-center mb-5 text-lg font-semibold text-white flex items-center justify-center gap-2">
            <IconLock class="w-5 h-5 opacity-80" />
            Login
         </h3>

         <!-- Email -->
         <input v-model="email" placeholder="Email" class="w-full mb-3 px-3 py-2 rounded-lg
               bg-black/40 border border-white/10
               text-white placeholder-gray-400
               focus:outline-none focus:ring-1 focus:ring-blue-500" />

         <!-- Password -->
         <input v-model="password" type="password" placeholder="Password" class="w-full mb-4 px-3 py-2 rounded-lg
               bg-black/40 border border-white/10
               text-white placeholder-gray-400
               focus:outline-none focus:ring-1 focus:ring-blue-500" />

         <!-- Button -->
         <button @click="login" :disabled="loading" class="w-full flex items-center justify-center gap-2
               px-3 py-2 rounded-lg text-sm
               bg-blue-600/20 text-blue-400
               hover:bg-blue-600/30
               transition disabled:opacity-40">
            <IconLogIn class="w-4 h-4" />

            <span v-if="!loading">Login</span>

            <span v-else class="flex items-center gap-2">
               <span class="w-4 h-4 border-2 border-blue-400 border-t-transparent rounded-full animate-spin"></span>
               Đang đăng nhập...
            </span>
         </button>

         <!-- Error -->
         <div v-if="error" class="mt-4 flex items-center justify-center gap-2
               px-3 py-2 rounded-lg text-sm
               bg-red-600/20 text-red-400">
            <IconCircleX class="w-4 h-4" />
            {{ error }}
         </div>

      </div>

   </div>
</template>