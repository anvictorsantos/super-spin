<template>
  <div id="app">
    <h1 class="text-center">SuperSpin Coaches</h1>
    <div class="filter-container">
      <SearchBar @search="handleSearch" />
    </div>
    <main>
      <div v-if="loading">Loading...</div>
      <div v-else-if="error" class="error">{{ error }}</div>

      <!-- DataTable with conditional row for no records -->
      <DataTable :fields="fields" :data="filteredCoaches" :sortableFields="sortableFields" />

      <!-- Show 'No records found' message if there are no filtered coaches -->
      <div v-if="filteredCoaches.length === 0" class="no-records">No records found</div>
    </main>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import apiClient from '@/services/axios' // Import the Axios instance
import SearchBar from '@/components/SearchBar.vue'
import DataTable from '@/components/DataTable.vue'
import type { Coach } from '@/types/Coach'

// Define props using defineProps
const props = defineProps<{
  fields: { key: string; label: string }[] // Assuming 'fields' is an array of objects with 'key' and 'label'
  sortableFields: string[] // An array of field names that can be sorted
}>()

// Define emits using defineEmits
const emit = defineEmits<{
  (e: 'search', query: string): void // Emit event when searching
}>()

// Declare reactive variables
const coaches = ref<Coach[]>([])
const loading = ref(true)
const error = ref<string | null>(null)
const searchQuery = ref('')
const sortOption = ref<'asc' | 'desc' | null>(null)
const fields = ref<{ key: string; label: string }[]>([]) // Will be dynamically set based on API response
const sortableFields = ref<string[]>(['hourly_rate']) // Static for now, can be enhanced as per the API fields

// Fetch coaches data from the API
const fetchCoaches = async () => {
  try {
    const response = await apiClient.get('/coaches') // Use the Axios instance
    coaches.value = response.data.map((coach: Coach) => ({
      ...coach,
      joined_at: new Date(coach.joined_at).toLocaleDateString(),
    }))

    // Dynamically set the fields based on the response keys
    if (coaches.value.length > 0) {
      const firstCoach = coaches.value[0]
      fields.value = Object.keys(firstCoach).map((key) => ({
        key,
        label: key.charAt(0).toUpperCase() + key.slice(1).replace('_', ' '), // Format key to label
      }))
    }
  } catch (err) {
    error.value = 'Failed to load coaches. Please try again later.'
  } finally {
    loading.value = false
  }
}

// Compute filtered coaches based on the search query and sorting option
const filteredCoaches = computed(() => {
  let result = [...coaches.value]

  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    result = result.filter(
      (coach) =>
        coach.name.toLowerCase().includes(query) || coach.location.toLowerCase().includes(query),
    )
  }

  if (sortOption.value === 'asc') {
    result.sort((a, b) => a.hourly_rate - b.hourly_rate)
  } else if (sortOption.value === 'desc') {
    result.sort((a, b) => b.hourly_rate - a.hourly_rate)
  }

  return result
})

// Handle the search event from SearchBar component
const handleSearch = (query: string) => {
  searchQuery.value = query
  emit('search', query) // Emit the search event
}

// Fetch coaches when the component is mounted
onMounted(fetchCoaches)
</script>
