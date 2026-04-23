<script setup lang="ts">
import { ref, onMounted } from "vue";
import { getProfile, updateProfile, type User } from "../services/auth";

const user = ref<User | null>(null);

const form = ref({
   fullname: "",
   phone: "",
   address: ""
});

const isEditing = ref(false);
const error = ref<string>('')
const success = ref<string>('')

async function fetchProfile() {
   const res = await getProfile();
   user.value = res.data.user || res.data;

   form.value = {
      fullname: res.data.user?.fullname || "",
      phone: res.data.user?.phone ?? "",
      address: res.data.user?.address || ""
   };
}

function startEdit() {
   isEditing.value = true;
}

function cancelEdit() {
   isEditing.value = false;
   fetchProfile(); // reset lại
}

async function saveProfile() {
   error.value = ''
   try {
      await updateProfile(form.value);
   } catch (err: any) {
      error.value = err.response?.data?.message || 'Có lỗi xảy ra'
      return
   }
   success.value = 'Cập nhật thành công';
   isEditing.value = false;
   fetchProfile(); // load lại profile mới nhất
}

onMounted(fetchProfile);
</script>

<template>
   <div class="flex justify-center items-start min-h-screen p-6
              bg-gray-50 dark:bg-[#0b0b0b] transition">

      <div class="w-full max-w-md rounded-2xl shadow-sm p-6
                bg-white border border-gray-200
                dark:bg-[#111] dark:border-gray-800">

         <!-- Avatar -->
         <div class="text-center">
            <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3 text-lg font-semibold
                    bg-gray-900 text-white
                    dark:bg-white dark:text-black">
               {{ user?.fullname?.charAt(0) || 'U' }}
            </div>

            <h5 class="font-semibold text-lg text-gray-900 dark:text-white">
               {{ user?.fullname }}
            </h5>

            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
               {{ user?.email }}
            </p>
         </div>

         <!-- Form -->
         <div class="space-y-4 text-sm">

            <!-- Name -->
            <div>
               <label class="flex items-center gap-2 mb-1 text-gray-600 dark:text-gray-400">
                  <IconUser class="w-4 h-4 opacity-70" />
                  Họ và tên
               </label>

               <input v-model="form.fullname" :disabled="!isEditing" class="w-full px-3 py-2 rounded-lg border transition
                   bg-white text-black border-gray-300
                   focus:outline-none focus:ring-2 focus:ring-black
                   dark:bg-[#0f0f0f] dark:text-white dark:border-gray-700
                   dark:focus:ring-white disabled:opacity-60" />
            </div>

            <!-- Phone -->
            <div>
               <label class="flex items-center gap-2 mb-1 text-gray-600 dark:text-gray-400">
                  <IconPhone class="w-4 h-4 opacity-70" />
                  Số điện thoại
               </label>

               <input v-model="form.phone" :disabled="!isEditing" class="w-full px-3 py-2 rounded-lg border transition
                   bg-white text-black border-gray-300
                   focus:outline-none focus:ring-2 focus:ring-black
                   dark:bg-[#0f0f0f] dark:text-white dark:border-gray-700
                   dark:focus:ring-white disabled:opacity-60" />
            </div>

            <!-- Address -->
            <div>
               <label class="flex items-center gap-2 mb-1 text-gray-600 dark:text-gray-400">
                  <IconMapPin class="w-4 h-4 opacity-70" />
                  Địa chỉ
               </label>

               <input v-model="form.address" :disabled="!isEditing" class="w-full px-3 py-2 rounded-lg border transition
                   bg-white text-black border-gray-300
                   focus:outline-none focus:ring-2 focus:ring-black
                   dark:bg-[#0f0f0f] dark:text-white dark:border-gray-700
                   dark:focus:ring-white disabled:opacity-60" />
            </div>

         </div>

         <!-- Buttons -->
         <div class="mt-6 space-y-2">

            <button v-if="!isEditing" @click="startEdit" class="w-full py-2 rounded-lg flex items-center justify-center gap-2 transition
                 bg-black text-white hover:opacity-80
                 dark:bg-white dark:text-black">
               <IconPencil class="w-4 h-4" />
               Edit Profile
            </button>

            <template v-else>
               <button @click="saveProfile" class="w-full py-2 rounded-lg flex items-center justify-center gap-2 transition
                   bg-green-600 text-white hover:opacity-90">
                  <IconSave class="w-4 h-4" />
                  Save
               </button>

               <button @click="cancelEdit" class="w-full py-2 rounded-lg flex items-center justify-center gap-2 border transition
                   border-gray-300 text-gray-700 hover:bg-gray-100
                   dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">
                  <IconX class="w-4 h-4" />
                  Cancel
               </button>
            </template>

         </div>

         <!-- Notification -->
         <div v-if="error" class="mt-4 p-3 rounded-lg text-sm flex items-center justify-center gap-2
               bg-red-100 text-red-600
               dark:bg-red-900/30 dark:text-red-400">
            <IconCircleX class="w-4 h-4" />
            {{ error }}
         </div>

         <div v-if="success" class="mt-4 p-3 rounded-lg text-sm flex items-center justify-center gap-2
               bg-green-100 text-green-600
               dark:bg-green-900/30 dark:text-green-400">
            <IconCircleCheck class="w-4 h-4" />
            {{ success }}
         </div>

      </div>
   </div>
   
</template>