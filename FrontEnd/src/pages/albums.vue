<script setup lang="ts">
import { ref, onMounted } from "vue";
import { getAlbums, deleteAlbum, type Album } from "../services/albums";

const albums = ref<Album[]>([]);
const loading = ref(false);

const loadData = async () => {
  loading.value = true;
  try {
    const res = await getAlbums();
    // Đảm bảo lấy đúng mảng data từ response của Laravel
    albums.value = res.data.data;
  } catch (error) {
    console.error("Lỗi khi tải danh sách:", error);
  } finally {
    loading.value = false;
  }
};

const handleDelete = async (id: number) => {
  if (!confirm("Xoá Album này?")) return;

  try {
    await deleteAlbum(id);
    albums.value = albums.value.filter(a => a.id !== id);
  } catch (error) {
    alert("Có lỗi xảy ra khi xóa!");
  }
};

onMounted(loadData);
</script>

<template>
  <div class="p-6">
    <div class="flex justify-between items-center mb-5">
      <h1 class="text-xl font-semibold text-gray-900 dark:text-white">
        Albums
      </h1>

      <router-link
        to="/admin/albums/create"
        class="px-4 py-2 bg-black text-white rounded-lg hover:opacity-80
               dark:bg-white dark:text-black"
      >
        + Add Album
      </router-link>
    </div>

    <div class="bg-white dark:bg-[#111] border rounded-xl shadow-sm overflow-hidden
                dark:border-gray-800">

      <table class="w-full text-sm">
        <thead class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
          <tr>
            <th class="p-3 text-left">#</th>
            <th class="p-3 text-left">Ảnh bìa</th>
            <th class="p-3 text-left">Tên Album</th>
            <th class="p-3 text-left">Nghệ sĩ</th> <th class="p-3 text-left">Trạng thái</th>
            <th class="p-3 text-right">Hành động</th>
          </tr>
        </thead>

        <tbody>
          <tr
            v-for="(item, index) in albums"
            :key="item.id"
            class="border-t dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-900 transition"
          >
            <td class="p-3">{{ index + 1 }}</td>

            <td class="p-3">
              <img 
                v-if="item.anh_bia" 
                :src="item.anh_bia" 
                class="w-10 h-10 object-cover rounded shadow-sm"
              />
              <span v-else class="text-gray-400 text-xs italic">No image</span>
            </td>

            <td class="p-3 font-medium text-gray-900 dark:text-white">
              {{ item.ten_album }}
            </td>

            <td class="p-3 text-gray-600 dark:text-gray-400">
              {{ item.nghe_si || '-' }}
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
                :to="`/admin/albums/edit/${item.id}`"
                class="px-2 py-1 text-xs bg-yellow-500 text-white rounded inline-block"
              >
                Edit
              </router-link>

              <button
                @click="handleDelete(item.id)"
                class="px-2 py-1 text-xs bg-red-600 text-white rounded inline-block"
              >
                Delete
              </button>
            </td>
          </tr>

          <tr v-if="!loading && albums.length === 0">
            <td colspan="6" class="text-center p-5 text-gray-500">
              Không có dữ liệu
            </td>
          </tr>

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