import { createApp } from 'vue'
import { createPinia } from 'pinia'
import { router } from '@/router/index.js'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'
import { plugin, defaultConfig } from '@formkit/vue'
import App from '@/App.vue'
import '@assets/main.css'
import axios from 'axios'
import { initTheme } from "@/utils/theme"

axios.defaults.baseURL = "http://backend.vm1.test/api"

const token = localStorage.getItem("token")
if (token) {
  axios.defaults.headers.common["Authorization"] = `Bearer ${token}`
  console.log("Auth header set from stored token")
} else {
  console.log("No token found in storage")
}

initTheme();

createApp(App)
  .use(createPinia().use(piniaPluginPersistedstate))
  .use(router)
  .use(plugin, defaultConfig)
  .mount('#app')
