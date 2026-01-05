<script setup>
import { ref } from "vue"
import { useRouter } from "vue-router"
import axios from "axios"

const router = useRouter()

const email = ref("")
const password = ref("")
const error = ref("")
const loading = ref(false)

async function login() {
  error.value = ""
  loading.value = true

  try {
    const res = await axios.post("http://backend.vm1.test/api/login", {
      email: email.value,
      password: password.value,
    })

    // Save token
    localStorage.setItem("token", res.data.token)

    // Set axios default auth header
    axios.defaults.headers.common.Authorization =
      `Bearer ${res.data.token}`

    // Redirect to catalog
    router.push("/catalog")
  } catch (err) {
    if (err.response?.status === 422) {
      // Validation errors
      error.value = Object.values(err.response.data.errors)
        .flat()
        .join(" ")
    } else if (err.response?.status === 401) {
      error.value = "Invalid email or password."
    } else {
      error.value = err.response?.data?.message || "Login failed."
    }
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
    <div class="bg-white w-full max-w-md rounded-2xl shadow-lg p-8">

      <h1 class="text-3xl font-bold text-center mb-6">
        Log In
      </h1>

      <form @submit.prevent="login" class="space-y-5">

        <div v-if="error" class="text-red-600 text-sm text-center">
          {{ error }}
        </div>

        <div>
          <label class="block text-sm font-semibold mb-1">Email</label>
          <input
            v-model="email"
            type="email"
            autocomplete="email"
            class="w-full rounded-lg border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
          />
        </div>

        <div>
          <label class="block text-sm font-semibold mb-1">Password</label>
          <input
            v-model="password"
            type="password"
            autocomplete="current-password"
            class="w-full rounded-lg border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
          />
        </div>

        <button
          type="submit"
          :disabled="loading"
          class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition disabled:opacity-50"
        >
          {{ loading ? "Logging in..." : "Log In" }}
        </button>
      </form>

      <div class="text-center mt-6 text-sm text-gray-600">
        Don't have an account?
        <RouterLink
          to="/signup"
          class="text-blue-600 font-semibold hover:underline"
        >
          Sign up
        </RouterLink>
      </div>

    </div>
  </div>
</template>
