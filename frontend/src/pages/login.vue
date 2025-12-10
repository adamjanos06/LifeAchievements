<script setup>
import { ref } from 'vue'

const email = ref('')
const password = ref('')

const handleLogin = () => {
  console.log('Login attempt:', email.value, password.value)
  // Később ide jön majd az API hívás
}
</script>

<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
    <div class="bg-white w-full max-w-md rounded-2xl shadow-lg p-8">

      <h1 class="text-3xl font-bold text-center mb-6">
        Log In
      </h1>

      <form @submit.prevent="handleLogin" class="space-y-5">
        
        <div>
          <label class="block text-sm font-semibold mb-1">Email</label>
          <input
            v-model="email"
            type="email"
            placeholder="you@example.com"
            class="w-full rounded-lg border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
          />
        </div>

        <div>
          <label class="block text-sm font-semibold mb-1">Password</label>
          <input
            v-model="password"
            type="password"
            placeholder="••••••••"
            class="w-full rounded-lg border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
          />
        </div>

        <button
          type="submit"
          class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition"
        >
          Log In
        </button>
      </form>

      <div class="text-center mt-6 text-sm text-gray-600">
        Don't have an account?
        <RouterLink to="/signup" class="text-blue-600 font-semibold hover:underline">
          Sign up
        </RouterLink>
      </div>

    </div>
  </div>
</template>
