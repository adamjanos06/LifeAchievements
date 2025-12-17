<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import MainNavbar from '@/components/layout/MainNavbar.vue'

const router = useRouter();

const categories = ref([]);
const achievements = ref([]);
const filtered = ref([]);
const selectedCategory = ref("");
const viewMode = ref("grid");

async function loadCategories() {
  const res = await fetch("/api/categories");
  categories.value = await res.json().data;
}

async function loadAchievements() {
  const res = await fetch("/api/achievements");
  achievements.value = await res.json().data;
  filtered.value = achievements.value;
}

function filterByCategory() {
  if (selectedCategory.value === "") {
    filtered.value = achievements.value;
  } else {
    filtered.value = achievements.value.filter(a =>
      a.category_id === Number(selectedCategory.value)
    );
  }
}

function goToCategory(id) {
  router.push(`/catalog/${id}`);
}

onMounted(() => {
  loadCategories();
  loadAchievements();
});
</script>

<template>
    <MainNavbar />
  <div>
    <!-- Category Cards for Quick Filter -->
    <div>
      <div v-for="cat in categories" :key="cat.id" @click="goToCategory(cat.id)">
        {{ cat.name }}
      </div>
    </div>

    <!-- Filter Bar -->
    <div>
      <select v-model="selectedCategory" @change="filterByCategory">
        <option value="">All Categories</option>
        <option v-for="cat in categories" :key="cat.id" :value="cat.id">
          {{ cat.name }}
        </option>
      </select>

      <!-- Placeholder for future filters -->
      <select>
        <option>Sort by</option>
        <option value="name">Name</option>
      </select>

      <!-- Grid/List Toggle -->
      <button @click="viewMode = 'grid'">Grid</button>
      <button @click="viewMode = 'list'">List</button>
    </div>

    <!-- Achievements -->
    <div v-if="viewMode === 'grid'">
      <div v-for="a in filtered" :key="a.id">
        {{ a.name }}
      </div>
    </div>

    <div v-else>
      <div v-for="a in filtered" :key="a.id">
        <strong>{{ a.name }}</strong>
        <p>{{ a.description }}</p>
      </div>
    </div>
  </div>
</template>
