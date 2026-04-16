<script setup>
import LandingNavbar from '@/components/layout/LandingNavbar.vue'
</script>

<template>
  <LandingNavbar />
  
  <!-- HERO SECTION -->
  <section class="max-w-7xl mx-auto px-10 pt-10 pb-28 flex flex-col-reverse lg:flex-row items-center justify-between gap-20">
    <!-- LEFT SIDE -->
    <div class="w-full lg:w-[620px] text-center lg:text-left flex flex-col items-center lg:items-start">
      
      <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight mb-8">
        Track Your Accomplishments <br />
        With Real <span class="tracking-wide">LIFE ACHIEVEMENTS</span>
      </h1>

      <p class="text-gray-800 text-lg lg:text-xl leading-relaxed mb-6 max-w-md mx-auto lg:mx-0 dark:text-gray-400">
        Set personal goals, unlock achievements, and track your progress across
        categories like fitness, learning, driving, productivity, and personal growth.
      </p>

      <p class="text-gray-800 text-lg lg:text-xl leading-relaxed mb-12 max-w-md mx-auto lg:mx-0 dark:text-gray-400">
        Whether you're building new habits or chasing big dreams, Life Achievements
        keeps you focused and motivated every step of the way.
      </p>

      <div class="flex gap-4 flex-col sm:flex-row">
        <router-link
          to="/login"
          class="inline-block bg-gray-600 hover:bg-gray-700 text-white font-bold px-10 py-4 rounded-2xl transition text-center"
        >
          LOG IN
        </router-link>
        <router-link
          to="/signup"
          class="inline-block bg-blue-700 hover:bg-blue-800 text-white font-bold px-10 py-4 rounded-2xl transition text-center"
        >
          SIGN UP
        </router-link>
      </div>

    </div>
      
    <!-- RIGHT SIDE – CHECKMARK (desktop only) -->
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

  <!-- INTRODUCTION SECTION -->
  <section class="max-w-6xl xl:max-w-7xl mx-auto px-8 lg:px-12 pt-16 pb-24">
    <h1 class="text-center text-4xl md:text-5xl font-extrabold tracking-wide mb-16">
      HOW IT WORKS
    </h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-20 xl:gap-32 items-stretch">
      <!-- WHAT IS LIFE ACHIEVEMENTS -->
      <div class="flex flex-col justify-between h-full">
        <div class="space-y-6">
          <h3 class="text-2xl font-bold">
            What is Life Achievements?
          </h3>

          <p class="text-base md:text-lg leading-loose text-gray-700 dark:text-gray-400">
            Life Achievements is a personal goal-tracking system that turns
            real-life progress into a fun, gamified experience.
          </p>

          <p class="text-base md:text-lg leading-loose text-gray-700 dark:text-gray-400">
            You can create goals, unlock achievements, earn points, and build
            streaks across different areas of your life.
          </p>

          <h4 class="text-lg font-semibold mt-4">
            Honor-based system:
          </h4>

          <p class="text-base md:text-lg leading-loose text-gray-700 dark:text-gray-400">
            The app does not verify real-life activity — your progress is
            based on your honesty and self-discipline.
          </p>

          <p class="text-base md:text-lg leading-loose text-gray-700 dark:text-gray-400">
            You decide what matters.<br />
            You define your progress.<br />
            You build your own achievement story.
          </p>
        </div>
      </div>

      <!-- HOW IT WORKS -->
      <div class="flex flex-col justify-between h-full">
        <div class="space-y-6">
          <h3 class="text-2xl font-bold">
            Getting Started
          </h3>

          <ol
            class="list-decimal pl-5 space-y-4 text-base md:text-lg text-gray-700 dark:text-gray-400 leading-loose"
          >
            <li>
              <span class="font-semibold">Choose or create achievements</span
              ><br />
              Pick goals from fitness, learning, productivity, and more.
            </li>

            <li>
              <span class="font-semibold">Complete them in real life</span
              ><br />
              Achievements represent real actions outside the app.
            </li>

            <li>
              <span class="font-semibold">Mark them as completed</span><br />
              Simply mark them done inside the app.
            </li>

            <li>
              <span class="font-semibold">Earn points & badges</span><br />
              Every completed achievement gives rewards.
            </li>

            <li>
              <span class="font-semibold">Track your personal progress</span
              ><br />
              Your profile shows stats and unlocked titles.
            </li>
          </ol>
        </div>
      </div>
    </div>
  </section>
</template>
