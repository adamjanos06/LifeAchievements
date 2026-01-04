<script setup>
import { ref, onMounted, computed } from "vue";
import { useRoute } from "vue-router";
import MainNavbar from "@/components/layout/MainNavbar.vue";

const route = useRoute();

const categories = ref([]);
const achievements = ref([]);
const filtered = ref([]);

const categoryId = Number(route.params.id);

async function loadCategories() {
  const res = await fetch("http://backend.vm1.test/api/categories");
  const json = await res.json();
  categories.value = json.data;
}

async function loadAchievements() {
  const res = await fetch("http://backend.vm1.test/api/achievements");
  const json = await res.json();
  achievements.value = json.data;
  filtered.value = achievements.value.filter(
    a => a.category_id === categoryId
  );
}

const categoryName = computed(() => {
  const cat = categories.value.find(c => c.id === categoryId);
  return cat ? cat.name.toUpperCase() : "";
});

onMounted(() => {
  loadCategories();
  loadAchievements();
});
</script>

<template>
  <MainNavbar />

  <div class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-10 py-14">

    <h2 class="text-center text-3xl font-bold tracking-wide mb-16">
      {{ categoryName }}
    </h2>

    <div
      class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3
             gap-x-6 gap-y-6
             sm:gap-x-10 sm:gap-y-10
             lg:gap-x-14 lg:gap-y-12"
    >

      <div
        v-for="a in filtered"
        :key="a.id"
        class="border rounded-2xl px-7 py-6 bg-white flex gap-5"
      >
        <div
          class="w-14 h-14 rounded-full bg-gray-200 flex items-center justify-center shrink-0"
        >
          <span class="text-lg font-bold text-gray-600">
            {{ categoryName.charAt(0) }}
          </span>
        </div>

        <div>
          <h3 class="font-semibold text-lg mb-1">
            {{ a.name }}
          </h3>
          <p class="text-sm text-gray-600 leading-snug">
            {{ a.description }}
          </p>
        </div>
      </div>

    </div>

    <div class="flex justify-center gap-4 mt-16">
      <div
        class="w-10 h-10 rounded-full bg-blue-700 text-white
               flex items-center justify-center font-semibold cursor-default"
      >
        1
      </div>
      <div
        class="w-10 h-10 rounded-full bg-gray-300 text-gray-700
               flex items-center justify-center font-semibold cursor-default"
      >
        2
      </div>
    </div>

  </div>
</template>

