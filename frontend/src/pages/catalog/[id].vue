<script setup>
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();

const categories = ref([]);
const achievements = ref([]);
const filtered = ref([]);
const selectedCategory = ref(route.params.id || "");
const viewMode = ref("grid");

async function loadCategories() {
  const res = await fetch("http://backend.vm1.test/api/categories");
  categories.value = await res.json();
  categories.value = categories.value.data;
  console.log(categories.value)
}

async function loadAchievements() {
  const res = await fetch("http://backend.vm1.test/api/achievements");
  achievements.value = await res.json();
  achievements.value = achievements.value.data;
  
  console.log(achievements.value)
  applyFilter();
}

function applyFilter() {
  filtered.value = achievements.value.filter(
    a => a.category_id === Number(selectedCategory.value)
  );
}

onMounted(() => {
  loadCategories();
  loadAchievements();
});
</script>

<template>
  <div>
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
