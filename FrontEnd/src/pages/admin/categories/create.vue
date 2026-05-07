<script setup lang="ts">
import { reactive, ref, computed, onMounted } from "vue";
import { useRouter, useRoute } from "vue-router";

import {
  createCategory,
  updateCategory,
  getCategory,
  type CategoryPayload,
} from "../../../services/category";

const router = useRouter();
const route = useRoute();

const loading = ref(false);
const errors = ref<Record<string, string[]>>({});

const id = computed(() => Number(route.params.id));
const isEdit = computed(() => !!route.params.id);

const form = reactive<CategoryPayload>({
  tentheloai: "",
  nhom: "",
  image: "",
  description: "",
  status: true,
});

// 📌 load data edit
const loadData = async () => {
  if (!isEdit.value) return;

  loading.value = true;

  try {
    const res = await getCategory(id.value);

    Object.assign(form, res.data.data);
  } finally {
    loading.value = false;
  }
};

// 📌 submit
const handleSubmit = async () => {
  loading.value = true;
  errors.value = {};

  try {
    if (isEdit.value) {
      await updateCategory(id.value, form);
    } else {
      await createCategory(form);
    }

    router.push("/admin/categories");
  } catch (err: any) {
    if (err.response?.data?.errors) {
      errors.value = err.response.data.errors;
    }
  } finally {
    loading.value = false;
  }
};

onMounted(loadData);
</script>

<template>
  <div class="p-6 max-w-4xl">

    <!-- Header -->
    <div class="mb-6">
      <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
        {{ isEdit ? "Edit Category" : "Create Category" }}
      </h1>

      <p class="text-sm text-gray-500 mt-1">
        {{
          isEdit
            ? "Cập nhật category"
            : "Thêm category mới"
        }}
      </p>
    </div>

    <!-- Form -->
    <div
      class="bg-white dark:bg-[#111]
             border border-gray-200 dark:border-gray-800
             rounded-2xl shadow-sm p-6"
    >
      <form @submit.prevent="handleSubmit" class="space-y-5">

        <!-- Tên -->
        <div>
          <label
            class="block mb-2 text-sm font-medium
                   text-gray-700 dark:text-gray-300"
          >
            Tên category
          </label>

          <input
            v-model="form.tentheloai"
            type="text"
            placeholder="Nhập tên category..."
            class="w-full px-4 py-3 rounded-xl
                   border border-gray-300 dark:border-gray-700
                   bg-white dark:bg-black
                   text-gray-900 dark:text-white
                   focus:ring-2 focus:ring-black
                   dark:focus:ring-white outline-none"
          />

          <p
            v-if="errors.tentheloai"
            class="mt-1 text-xs text-red-500"
          >
            {{ errors.tentheloai[0] }}
          </p>
        </div>

        <!-- Nhóm -->
        <div>
          <label
            class="block mb-2 text-sm font-medium
                   text-gray-700 dark:text-gray-300"
          >
            Nhóm
          </label>

          <input
            v-model="form.nhom"
            type="text"
            placeholder="Ví dụ: news, blog..."
            class="w-full px-4 py-3 rounded-xl
                   border border-gray-300 dark:border-gray-700
                   bg-white dark:bg-black
                   text-gray-900 dark:text-white
                   focus:ring-2 focus:ring-black
                   dark:focus:ring-white outline-none"
          />
        </div>

        <!-- Image -->
        <div>
          <label
            class="block mb-2 text-sm font-medium
                   text-gray-700 dark:text-gray-300"
          >
            Image URL
          </label>

          <input
            v-model="form.image"
            type="text"
            placeholder="https://..."
            class="w-full px-4 py-3 rounded-xl
                   border border-gray-300 dark:border-gray-700
                   bg-white dark:bg-black
                   text-gray-900 dark:text-white
                   focus:ring-2 focus:ring-black
                   dark:focus:ring-white outline-none"
          />
        </div>

        <!-- Description -->
        <div>
          <label
            class="block mb-2 text-sm font-medium
                   text-gray-700 dark:text-gray-300"
          >
            Description
          </label>

          <textarea
            v-model="form.description"
            rows="4"
            placeholder="Nhập mô tả..."
            class="w-full px-4 py-3 rounded-xl
                   border border-gray-300 dark:border-gray-700
                   bg-white dark:bg-black
                   text-gray-900 dark:text-white
                   focus:ring-2 focus:ring-black
                   dark:focus:ring-white outline-none"
          />
        </div>

        <!-- Status -->
        <div>
          <label
            class="block mb-2 text-sm font-medium
                   text-gray-700 dark:text-gray-300"
          >
            Status
          </label>

          <select
            v-model="form.status"
            class="w-full px-4 py-3 rounded-xl
                   border border-gray-300 dark:border-gray-700
                   bg-white dark:bg-black
                   text-gray-900 dark:text-white
                   focus:ring-2 focus:ring-black
                   dark:focus:ring-white outline-none"
          >
            <option :value="true">Active</option>
            <option :value="false">Inactive</option>
          </select>
        </div>

        <!-- Actions -->
        <div class="flex items-center gap-3 pt-2">

          <button
            type="submit"
            :disabled="loading"
            class="px-5 py-3 rounded-xl
                   bg-black text-white
                   hover:opacity-80
                   disabled:opacity-50
                   transition
                   dark:bg-white dark:text-black"
          >
            {{
              loading
                ? "Saving..."
                : isEdit
                  ? "Update Category"
                  : "Create Category"
            }}
          </button>

          <router-link
            to="/admin/categories"
            class="px-5 py-3 rounded-xl
                   border border-gray-300 dark:border-gray-700
                   text-gray-700 dark:text-gray-300
                   hover:bg-gray-100 dark:hover:bg-gray-900
                   transition"
          >
            Cancel
          </router-link>

        </div>

      </form>
    </div>
  </div>
</template>