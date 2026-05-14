import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import { registerIcons } from './plugins/lucide'
import Toast from 'vue-toastification'
import 'vue-toastification/dist/index.css'

import './assets/tailwind.css'
import './style.css'

// ✅ INIT THEME (chỉ 1 lần)
const saved = localStorage.getItem('theme')
if (saved === 'dark') {
  document.documentElement.classList.add('dark')
} else if (saved === 'light') {
  document.documentElement.classList.remove('dark')
} else {
  const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches
  document.documentElement.classList.toggle('dark', prefersDark)
}

const app = createApp(App)
app.use(router)
registerIcons(app)
app.use(Toast)
app.mount('#app')