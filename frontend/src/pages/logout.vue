<script setup>
import axios from "axios"
import { useRouter } from "vue-router"

const router = useRouter()

async function logout() {
  try {
    await axios.post("/logout")
  } catch (e) {
  }

  localStorage.removeItem("token")
  delete axios.defaults.headers.common["Authorization"]

  router.push("/")
}

logout()
</script>

<template>
  <div class="p-8 text-center">
    <p>Logging you out...</p>
  </div>
</template>