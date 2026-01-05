<script setup>
import { ref, onMounted } from "vue"
import axios from "axios"
import MainNavbar from "@/components/layout/MainNavbar.vue"

const user = ref(null)
const loading = ref(true)
const error = ref(null)

const token = localStorage.getItem("token")

onMounted(async () => {
  if (!token) {
    loading.value = false
    return
  }

  try {
    const res = await axios.get("/me")
    user.value = res.data
  } catch (err) {
    error.value = "You are not logged in."
  } finally {
    loading.value = false
  }
})
</script>

<template>
  <MainNavbar />

  <div
    class="max-w-4xl mx-auto px-5 py-14
           text-gray-900 dark:text-gray-100
           transition-colors"
  >
    <h1 class="text-3xl font-bold mb-8">
      Profile
    </h1>

    <!-- Loading -->
    <p v-if="loading">
      Loading...
    </p>

    <!-- NOT LOGGED IN -->
    <div
      v-else-if="!user"
      class="text-center space-y-4"
    >
      <p class="text-gray-600 dark:text-gray-400">
        You need to log in to view your profile.
      </p>

      <RouterLink
        to="/login"
        class="bg-blue-600 hover:bg-blue-700
               text-white px-5 py-2
               rounded-lg font-semibold transition"
      >
        Log In
      </RouterLink>
    </div>

    <!-- LOGGED IN -->
    <div
      v-else
      class="bg-white dark:bg-gray-800
             shadow-md rounded-2xl
             p-8 space-y-3
             transition-colors"
    >
      <p><strong>Name:</strong> {{ user.name }}</p>
      <p><strong>Email:</strong> {{ user.email }}</p>
      <p><strong>ID:</strong> {{ user.id }}</p>

      <RouterLink
        to="/logout"
        class="inline-block mt-4
               bg-red-600 hover:bg-red-700
               text-white px-4 py-2
               rounded-lg font-semibold transition"
      >
        Log Out
      </RouterLink>
    </div>
  </div>
</template>
