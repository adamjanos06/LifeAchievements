<script setup>
import AuthCardLayout from "@/components/auth/AuthCardLayout.vue"
import { useSignupPage } from "@/utils/composables/useSignupPage.js"

const {
  name,
  email,
  password,
  password_confirmation,
  error,
  register,
} = useSignupPage()
</script>

<template>
  <AuthCardLayout title="Sign Up">
    <form @submit.prevent="register" class="space-y-5">
      <div
        v-if="error"
        class="text-red-700 dark:text-red-300 text-base text-center
               bg-red-50 dark:bg-red-900/25 border border-red-200 dark:border-red-800
               rounded-lg px-3 py-2"
      >
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
          pattern="[A-Za-z0-9]+"
          title="Only letters and numbers are allowed."
          maxlength="32"
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
  </AuthCardLayout>
</template>
