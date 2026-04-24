<script setup lang="ts">
import { ref, onMounted } from "vue";
import { getCategories, deleteCategory, type Category } from "../services/category";

// import {
//   getCategories,
//   createCategory,
//   deleteCategory,
// } from "../services/category";

const categories = ref<Category[]>([]);
const loading = ref(false);

const loadData = async () => {
  loading.value = true;
  try {
    const res = await getCategories();
    categories.value = res.data.data;
  } finally {
    loading.value = false;
  }
};

const handleDelete = async (id: number) => {
  if (!confirm("Xoá category này?")) return;

  await deleteCategory(id);
  categories.value = categories.value.filter(c => c.id !== id);
};

onMounted(loadData);
</script>

<template>
  <div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-5">
      <h1 class="text-xl font-semibold text-gray-900 dark:text-white">
        Categories
      </h1>

      <router-link
        to="/admin/categories/create"
        class="px-4 py-2 bg-black text-white rounded-lg hover:opacity-80
               dark:bg-white dark:text-black"
      >
        + Add Category
      </router-link>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-[#111] border rounded-xl shadow-sm overflow-hidden
                dark:border-gray-800">

      <table class="w-full text-sm">
        <thead class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
          <tr>
            <th class="p-3 text-left">#</th>
            <th class="p-3 text-left">Tên</th>
            <th class="p-3 text-left">Nhóm</th>
            <th class="p-3 text-left">Trạng thái</th>
            <th class="p-3 text-right">Hành động</th>
          </tr>
        </thead>

        <tbody>
          <tr
            v-for="(item, index) in categories"
            :key="item.id"
            class="border-t dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-900 transition"
          >
            <td class="p-3 font-medium text-gray-900 dark:text-white">{{ index + 1 }}</td>

            <td class="p-3 font-medium text-gray-900 dark:text-white">
              {{ item.tentheloai }}
            </td>

            <td class="p-3 text-gray-600 dark:text-gray-400">
              {{ item.nhom || '-' }}
            </td>

            <td class="p-3">
              <span
                class="px-2 py-1 rounded text-xs font-medium"
                :class="item.status
                  ? 'bg-green-100 text-green-600'
                  : 'bg-red-100 text-red-500'"
              >
                {{ item.status ? 'Active' : 'Inactive' }}
              </span>
            </td>

            <td class="p-3 text-right space-x-2">
              <router-link
                :to="`/admin/categories/edit/${item.id}`"
                class="px-2 py-1 text-xs bg-yellow-500 text-white rounded"
              >
                Edit
              </router-link>

              <button
                @click="handleDelete(item.id)"
                class="px-2 py-1 text-xs bg-red-600 text-white rounded"
              >
                Delete
              </button>
            </td>
          </tr>

          <!-- Empty -->
          <tr v-if="!loading && categories.length === 0">
            <td colspan="5" class="text-center p-5 text-gray-500">
              Không có dữ liệu
            </td>
          </tr>

          <!-- Loading -->
          <tr v-if="loading">
            <td colspan="5" class="text-center p-5 text-gray-500">
              Loading...
            </td>
          </tr>
        </tbody>
      </table>

    </div>
  </div>
</template>