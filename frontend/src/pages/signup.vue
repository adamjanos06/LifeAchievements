<script setup>
import { ref } from 'vue'

const username = ref('')
const email = ref('')
const password = ref('')
const password2 = ref('')

const handleSignup = () => {
  if (password.value !== password2.value) {
    alert('Passwords do not match!')
    return
  }

  console.log('Signup:', {
    username: username.value,
    email: email.value,
    password: password.value
  })

}
</script>

<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
    <div class="bg-white w-full max-w-md rounded-2xl shadow-lg p-8">

      <h1 class="text-3xl font-bold text-center mb-6">
        Sign Up
      </h1>
      <form @submit.prevent="handleSignup" class="space-y-5">

        <div>
          <label class="block text-sm font-semibold mb-1">Username</label>
          <input
            v-model="username"
            type="text"
            placeholder="Your name"
            class="w-full rounded-lg border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
          />
        </div>

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

        <div>
          <label class="block text-sm font-semibold mb-1">Confirm Password</label>
          <input
            v-model="password2"
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
          Create Account
        </button>

      </form>

      <div class="text-center mt-6 text-sm text-gray-600">
        Already have an account?
        <RouterLink to="/login" class="text-blue-600 font-semibold hover:underline">
          Log in
        </RouterLink>
      </div>

    </div>
  </div>
</template>
