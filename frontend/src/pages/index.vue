<script setup>
import LandingNavbar from '@/components/layout/LandingNavbar.vue'
</script>

<template>
  <LandingNavbar />

  <!-- 🔽 EZ ALATT KELL LENNIE A HERO SZEKCIÓDNAK -->
<section class="max-w-7xl mx-auto px-10 pt-10 pb-28 flex flex-col-reverse lg:flex-row items-center justify-between gap-20">
    <!-- BAL OLDAL -->
    <div class="w-full lg:w-[620px] text-center lg:text-left flex flex-col items-center lg:items-start">
      <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight mb-8">
        Track Your Accomplishments <br />
        With Real <span class="tracking-wide">LIFE ACHIEVEMENTS</span>
      </h1>

      <p class="text-gray-800 text-lg lg:text-xl leading-relaxed mb-6 max-w-md mx-auto lg:mx-0">
        Set personal goals, unlock achievements, and track your progress across
        categories like fitness, learning, driving, productivity, and personal growth.
      </p>

      <p class="text-gray-800 text-lg lg:text-xl leading-relaxed mb-12 max-w-md mx-auto lg:mx-0">
        Whether you're building new habits or chasing big dreams, Life Achievements
        keeps you focused and motivated every step of the way.
      </p>

<router-link
  to="/introduction"
  class="inline-block bg-blue-700 hover:bg-blue-800 text-white font-bold px-10 py-4 rounded-2xl transition"
>
  GET STARTED
</router-link>

    </div>

    <!-- JOBB OLDAL – PIPA (DESKTOP) -->
<div class="hidden lg:flex w-[360px] justify-end">
  <div class="w-56 h-56 bg-blue-700 rounded-full flex items-center justify-center shadow-2xl">
    <svg
      xmlns="http://www.w3.org/2000/svg"
      class="w-28 h-28 text-white"
      fill="none"
      viewBox="0 0 24 24"
      stroke="currentColor"
      stroke-width="3"
    >
      <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
    </svg>
  </div>
</div>

  </section>
</template>