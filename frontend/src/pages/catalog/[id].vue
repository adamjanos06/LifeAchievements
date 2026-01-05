<script setup>
import { ref, onMounted, computed } from "vue";
import { useRoute } from "vue-router";
import MainNavbar from "@/components/layout/MainNavbar.vue";

const route = useRoute();

const categories = ref([]);
const achievements = ref([]);
const filtered = ref([]);

const categoryId = Number(route.params.id);

const selected = ref(null);
const showModal = ref(false);

const currentPage = ref(1);
const perPage = 9;

function openModal(a) {
  selected.value = a;
  showModal.value = true;
}

function closeModal() {
  selected.value = null;
  showModal.value = false;
}

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

const icon = computed(() => {
  const cat = categories.value.find(c => c.id === categoryId);
  return cat ? cat.icon : "";
});

const totalPages = computed(() => {
  return Math.min(2, Math.ceil(filtered.value.length / perPage));
});

const paginatedAchievements = computed(() => {
  const start = (currentPage.value - 1) * perPage;
  return filtered.value.slice(start, start + perPage);
});

function goToPage(page) {
  if (page >= 1 && page <= totalPages.value) {
    currentPage.value = page;
  }
}

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
        v-for="a in paginatedAchievements"
        :key="a.id"
        class="border rounded-2xl px-7 py-6 bg-white flex gap-5 cursor-pointer hover:shadow-lg transition"
        @click="openModal(a)"
      >
        <div class="w-16 h-16 rounded-full flex items-center justify-center">
          <img
            v-if="icon"
            :src="icon"
            alt="Category Icon"
            class="w-20 h-20 object-contain"
          />
          <span v-else class="text-lg font-bold text-gray-600">
            {{ categoryName }}
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

    <div
      v-if="totalPages > 1"
      class="flex justify-center gap-4 mt-16"
    >
      <button
        v-for="page in totalPages"
        :key="page"
        @click="goToPage(page)"
        class="w-10 h-10 rounded-full
               flex items-center justify-center
               font-semibold transition"
        :class="page === currentPage
          ? 'bg-blue-700 text-white'
          : 'bg-gray-300 text-gray-700 hover:bg-gray-400'"
      >
        {{ page }}
      </button>
    </div>

  </div>


  <div
    v-if="showModal"
    class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
  >
    <div class="bg-white rounded-2xl shadow-xl p-8 w-full max-w-md relative">

      <button
        @click="closeModal"
        class="absolute top-4 right-4 text-2xl leading-none"
      >
        x
      </button>

      <div class="flex flex-col items-center text-center gap-4">

        <img
          v-if="icon"
          :src="icon"
          class="w-20 h-20 object-contain"
        />

        <h2 class="text-2xl font-bold">
          {{ selected?.name }}
        </h2>

        <p class="text-gray-600">
          {{ selected?.description }}
        </p>

        <div class="w-full flex gap-3 mt-3">
          <button
            class="flex-1 bg-green-600 text-white py-2 rounded-lg font-semibold"
          >
            MARK AS COMPLETED
          </button>

          <button
            class="flex-1 bg-blue-600 text-white py-2 rounded-lg font-semibold"
          >
            SAVE TO GOALS
          </button>
        </div>

        <div class="text-left w-full mt-3">
          <p class="font-semibold">Reward:</p>
          <p>{{ selected?.xp }} XP</p>
          <p>{{ selected?.badge }}</p>
        </div>

      </div>

    </div>
  </div>

</template>
