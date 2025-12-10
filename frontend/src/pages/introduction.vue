<script setup>
import LandingNavbar from '@/components/layout/LandingNavbar.vue'
</script>
<template>
  <LandingNavbar />
    <!-- INTRO TITLE + CONTENT -->
    <section class="max-w-6xl xl:max-w-7xl mx-auto px-8 lg:px-12 pt-16 pb-24">
      <h1 class="text-center text-4xl md:text-5xl font-extrabold tracking-wide">
        INTRODUCTION
      </h1>

      <!-- TWO COLUMN GRID -->
      <div
        class="grid grid-cols-1 md:grid-cols-2 gap-20 xl:gap-32 mt-16 items-stretch"
      >
        <!-- LEFT COLUMN -->
        <div class="flex flex-col justify-between h-full">
          <div class="space-y-6">
            <h3 class="text-2xl font-bold">
              What is Life Achievements?
            </h3>

            <p class="text-base md:text-lg leading-loose text-gray-700">
              Life Achievements is a personal goal-tracking system that turns
              real-life progress into a fun, gamified experience.
            </p>

            <p class="text-base md:text-lg leading-loose text-gray-700">
              You can create goals, unlock achievements, earn points, and build
              streaks across different areas of your life.
            </p>

            <h4 class="text-lg font-semibold mt-4">
              Honor-based system:
            </h4>

            <p class="text-base md:text-lg leading-loose text-gray-700">
              The app does not verify real-life activity — your progress is
              based on your honesty and self-discipline.
            </p>

            <p class="text-base md:text-lg leading-loose text-gray-700">
              You decide what matters.<br />
              You define your progress.<br />
              You build your own achievement story.
            </p>
          </div>

          <button
            class="mt-10 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl py-4 text-lg font-semibold transition"
          >
            SIGN UP
          </button>
        </div>

        <!-- RIGHT COLUMN -->
        <div class="flex flex-col justify-between h-full">
          <div class="space-y-6">
            <h3 class="text-2xl font-bold">
              How It Works
            </h3>

            <ol
              class="list-decimal pl-5 space-y-4 text-base md:text-lg text-gray-700 leading-loose"
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

          <button
            class="mt-10 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl py-4 text-lg font-semibold transition"
          >
            VIEW ACHIEVEMENTS
          </button>
        </div>
      </div>
    </section>
</template>