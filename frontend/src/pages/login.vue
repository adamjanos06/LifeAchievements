<script setup>
import AuthCardLayout from "@/components/auth/AuthCardLayout.vue"
import { useLoginPage } from "@/utils/composables/useLoginPage.js"

const { email, password, error, loading, login } = useLoginPage()
</script>

<template>
  <AuthCardLayout title="Log In">
    <form @submit.prevent="login" class="space-y-5">
      <div v-if="error" class="text-red-600 text-sm text-center">
        {{ error }}
      </div>

      <div>
        <label class="block text-sm font-semibold mb-1">
          Email
        </label>
        <input
          v-model="email"
          type="email"
          autocomplete="email"
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
          autocomplete="current-password"
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
        :disabled="loading"
        class="w-full bg-blue-600 hover:bg-blue-700
               text-white font-bold py-3 rounded-xl
               transition disabled:opacity-50"
      >
        {{ loading ? "Logging in..." : "Log In" }}
      </button>
    </form>

    <div class="text-center mt-6 text-sm text-gray-600 dark:text-gray-400">
      Don't have an account?
      <RouterLink
        to="/signup"
        class="text-blue-600 dark:text-blue-400
               font-semibold hover:underline"
      >
        Sign up
      </RouterLink>
    </div>
  </AuthCardLayout>
</template>
