<script setup>
import { ref } from "vue"
import { useRouter } from "vue-router"
import axios from "axios"

const router = useRouter()

const name = ref("")
const email = ref("")
const password = ref("")
const password_confirmation = ref("")
const error = ref("")

async function register() {
  error.value = ""

  if (password.value !== password_confirmation.value) {
    error.value = "Passwords do not match"
    return
  }

  try {
    const res = await axios.post("http://backend.vm1.test/api/register", {
      name: name.value,
      email: email.value,
      password: password.value,
      password_confirmation: password_confirmation.value,
    })

    localStorage.setItem("token", res.data.token)
    axios.defaults.headers.common.Authorization = `Bearer ${res.data.token}`

    router.push("/catalog")
  } catch (err) {
    error.value = err.response?.data?.message || "Registration failed."
  }
}
</script>

<template>
  <div
    class="min-h-screen flex items-center justify-center px-4
           bg-gray-100 dark:bg-gray-900
           text-gray-900 dark:text-gray-100
           transition-colors"
  >
    <div
      class="w-full max-w-md rounded-2xl shadow-lg p-8
             bg-white dark:bg-gray-800
             transition-colors"
    >
      <h1 class="text-3xl font-bold text-center mb-6">
        Sign Up
      </h1>

      <form @submit.prevent="register" class="space-y-5">

        <div v-if="error" class="text-red-600 text-sm text-center">
          {{ error }}
        </div>

        <div>
          <label class="block text-sm font-semibold mb-1">
            Username
          </label>
          <input
            v-model="name"
            type="text"
            placeholder="Your name"
            class="w-full rounded-lg border px-4 py-2
                   bg-white dark:bg-gray-700
                   border-gray-300 dark:border-gray-600
                   text-gray-900 dark:text-gray-100
                   focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
          />
        </div>

        <div>
          <label class="block text-sm font-semibold mb-1">
            Email
          </label>
          <input
            v-model="email"
            type="email"
            placeholder="you@example.com"
            class="w-full rounded-lg border px-4 py-2
                   bg-white dark:bg-gray-700
                   border-gray-300 dark:border-gray-600
                   text-gray-900 dark:text-gray-100
                   focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
          />
        </div>

        <div>
          <label class="block text-sm font-semibold mb-1">
            Password
          </label>
          <input
            v-model="password"
            type="password"
            placeholder="••••••••"
            class="w-full rounded-lg border px-4 py-2
                   bg-white dark:bg-gray-700
                   border-gray-300 dark:border-gray-600
                   text-gray-900 dark:text-gray-100
                   focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
          />
        </div>

        <div>
          <label class="block text-sm font-semibold mb-1">
            Confirm Password
          </label>
          <input
            v-model="password_confirmation"
            type="password"
            placeholder="••••••••"
            class="w-full rounded-lg border px-4 py-2
                   bg-white dark:bg-gray-700
                   border-gray-300 dark:border-gray-600
                   text-gray-900 dark:text-gray-100
                   focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
          />
        </div>

        <button
          type="submit"
          class="w-full bg-blue-600 hover:bg-blue-700
                 text-white font-bold py-3 rounded-xl transition"
        >
          Create Account
        </button>
      </form>

      <div class="text-center mt-6 text-sm text-gray-600 dark:text-gray-400">
        Already have an account?
        <RouterLink
          to="/login"
          class="text-blue-600 dark:text-blue-400
                 font-semibold hover:underline"
        >
          Log in
        </RouterLink>
      </div>
    </div>
  </div>
</template>
