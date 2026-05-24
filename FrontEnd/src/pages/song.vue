<script setup lang="ts">
import { ref, onMounted } from "vue";
import { getSongs, type Song } from "../services/song";

const songs = ref<Song[]>([]);
const loading = ref(false);

const loadData = async () => {
  loading.value = true;
  try {
    const res = await getSongs();
    songs.value = res.data.data;
  } finally {
    loading.value = false;
  }
};

// const handleDelete = async (id: number) => {
//   if (!confirm("Xoá bài hát này?")) return;

//   await deleteSong(id);
//   songs.value = songs.value.filter(s => s.id !== id);
// };

onMounted(loadData);
</script>

<template>
  <div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-5">
      <h1 class="text-xl font-semibold text-gray-900 dark:text-white">
        Songs
      </h1>

      <router-link
          to="/admin/songs/create"
          class="px-4 py-2 bg-black text-white rounded-lg hover:opacity-80
               dark:bg-white dark:text-black"
      >
        + Add Song
      </router-link>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-[#111] border rounded-xl shadow-sm overflow-hidden
                dark:border-gray-800">

      <table class="w-full text-sm">
        <thead class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
        <tr>
          <th class="p-3 text-left">#</th>
          <th class="p-3 text-left">Tên bài hát</th>
          <th class="p-3 text-left">Nghệ sĩ</th>
          <th class="p-3 text-left">Thể loại</th>
          <th class="p-3 text-left">Ảnh</th>
          <th class="p-3 text-right">Hành động</th>
        </tr>
        </thead>

        <tbody>
        <tr
            v-for="(item, index) in songs"
            :key="item.id"
            class="border-t dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-900 transition"
        >
          <td class="p-3">{{ index + 1 }}</td>

          <td class="p-3 font-medium text-gray-900 dark:text-white">
            {{ item.tenbaihat }}
          </td>

          <td class="p-3 text-gray-600 dark:text-gray-400">
            {{ item.nghesi }}
          </td>

          <td class="p-3 text-gray-600 dark:text-gray-400">
            {{ item.theloai }}
          </td>

          <td class="p-3">
            <img
                v-if="item.anh_daidien"
                :src="item.anh_daidien"
                alt="cover"
                class="w-12 h-12 object-cover rounded"
            />
            <span v-else class="text-gray-400 text-xs">No image</span>
          </td>

          <td class="p-3 text-right space-x-2">
            <router-link
                :to="`/admin/songs/edit/${item.id}`"
                class="px-2 py-1 text-xs bg-yellow-500 text-white rounded"
            >
              Edit
            </router-link>

            <!-- <button
              @click="handleDelete(item.id)"
              class="px-2 py-1 text-xs bg-red-600 text-white rounded"
            >
              Delete
            </button> -->
          </td>
        </tr>

        <!-- Empty -->
        <tr v-if="!loading && songs.length === 0">
          <td colspan="6" class="text-center p-5 text-gray-500">
            Không có dữ liệu
          </td>
        </tr>

        <!-- Loading -->
        <tr v-if="loading">
          <td colspan="6" class="text-center p-5 text-gray-500">
            Loading...
          </td>
        </tr>
        </tbody>
      </table>

    </div>
  </div>
</template>