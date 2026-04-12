  <script setup lang="ts">
  import { ref, onMounted } from 'vue'
  import axios from 'axios'

  type User = {
    id: number
    name: string
    email: string
  }

  const users = ref<User[]>([])
  const form = ref({ name: '', email: '' })
  const error = ref('')
  const loading = ref(false)

  // ⚙️ base URL
  const API = 'http://127.0.0.1:8000/api/users'

  // ⚙️ lấy token
  const getAuth = () => ({
    headers: {
      Authorization: 'Bearer ' + localStorage.getItem('token'),
    },
  })

  async function fetchUsers() {
    loading.value = true
    error.value = ''

    try {
      const res = await axios.get(`${API}/users`, getAuth())
      users.value = res.data.data || res.data
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Lỗi load users'
    } finally {
      loading.value = false
    }
  }

  async function createUser() {
    error.value = ''
    try {
      const res = await axios.post(`${API}/users`, form.value, getAuth())
      users.value.push(res.data.data || res.data)
      form.value = { name: '', email: '' }
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Lỗi thêm user'
    }
  }

  async function deleteUser(id: number) {
    if (!confirm('Xóa user này?')) return
    try {
      await axios.delete(`${API}/users/${id}`, getAuth())
      users.value = users.value.filter(u => u.id !== id)
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Lỗi xóa user'
    }
  }

  onMounted(fetchUsers)
  </script>

<template>
  <div>
    <h2>Users</h2>

    <!-- ⚠️ ERROR -->
    <div v-if="error" class="alert alert-danger">
      {{ error }}
    </div>

    <!-- ⚙️ FORM -->
    <div class="card p-3 mb-3">
      <input v-model="form.name" class="form-control mb-2" placeholder="Name" />
      <input v-model="form.email" class="form-control mb-2" placeholder="Email" />
      <button class="btn btn-success" @click="createUser">
        Add
      </button>
    </div>

    <!-- ⏳ LOADING -->
    <div v-if="loading">Loading...</div>

    <!-- 📋 TABLE -->
    <table v-else class="table">
      <tr v-for="u in users" :key="u.id">
        <td>{{ u.name }}</td>
        <td>{{ u.email }}</td>
        <td>
          <button class="btn btn-danger btn-sm" @click="deleteUser(u.id)">
            Delete
          </button>
        </td>
      </tr>
    </table>
  </div>
</template>