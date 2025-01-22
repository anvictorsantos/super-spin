<template>
  <div id="app">
    <h1 class="text-center">SuperSpin Coaches</h1>
    <div class="filter-container">
      <SearchBar @search="handleSearch" />
    </div>
    <main>
      <div v-if="loading">Loading...</div>
      <div v-else-if="error" class="error">{{ error }}</div>

      <!-- Pass the filtered data to the DataTable -->
      <DataTable
        :fields="fields"
        :data="filteredCoaches"
        :sortableFields="sortableFields"
        @sortChanged="handleSortChange"
      />

      <!-- Show 'No records found' message if there are no filtered coaches -->
      <div v-if="filteredCoaches.length === 0" class="no-records">No records found</div>
    </main>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import apiClient from '@/services/axios'
import SearchBar from '@/components/SearchBar.vue'
import DataTable from '@/components/DataTable.vue'
import type { Coach } from '@/types/Coach'

// Declare reactive variables
const coaches = ref<Coach[]>([])
const loading = ref(true)
const error = ref<string | null>(null)
const searchQuery = ref('')
const fields = ref<{ key: string; label: string }[]>([])
const sortableFields = ref<string[]>(['hourly_rate'])

// Fetch coaches data from the API
const fetchCoaches = async () => {
  try {
    const response = await apiClient.get('/coaches')
    coaches.value = response.data.map((coach: Coach) => ({
      ...coach,
      joined_at: new Date(coach.joined_at).toLocaleDateString(),
    }))
    if (coaches.value.length > 0) {
      const firstCoach = coaches.value[0]
      fields.value = Object.keys(firstCoach).map((key) => ({
        key,
        label: key.charAt(0).toUpperCase() + key.slice(1).replace('_', ' '),
      }))
    }
  } catch (err) {
    error.value = 'Failed to load coaches. Please try again later.'
  } finally {
    loading.value = false
  }
}

// Compute filtered coaches based on the search query
const filteredCoaches = computed(() => {
  let result = [...coaches.value]
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    result = result.filter(
      (coach) =>
        coach.name.toLowerCase().includes(query) || coach.location.toLowerCase().includes(query),
    )
  }
  return result
})

// Handle the search event from SearchBar component
const handleSearch = (query: string) => {
  searchQuery.value = query
}

// Handle sort changes from DataTable
const handleSortChange = (sortConfig: { key: string; order: 'asc' | 'desc' }) => {
  // You can handle additional sorting logic here, e.g., modifying the filtered data
  console.log(sortConfig) // For debugging purposes
}

// Fetch coaches when the component is mounted
onMounted(fetchCoaches)
</script>
