<template>
  <nav>
    <a class="sr-only" href="#main-content">Skip to main content</a>
  </nav>

  <div class="header-container">
    <h1 id="main-content" tabindex="-1" role="heading" aria-level="1">SuperSpin Coaches</h1>
    <SearchBar @search="handleSearch" aria-label="Search Coaches" />
  </div>

  <main>
    <!-- Provide ARIA live region for loading and error messages -->
    <div v-if="loading" role="status" aria-live="polite">Loading...</div>
    <div v-else-if="error" class="error" role="alert" aria-live="assertive">{{ error }}</div>

    <!-- Pass the filtered data to the DataTable and ensure it's properly announced to screen readers -->
    <DataTable :fields="fields" :data="filteredCoaches" :sortableFields="sortableFields">
      <!-- Show 'No records found' message if there are no filtered coaches -->
      <template #no-records v-if="filteredCoaches.length === 0">
        <p class="no-records" role="alert">No records found</p>
      </template>
    </DataTable>
  </main>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import apiClient from '@/services/axios'
import SearchBar from '@/components/SearchBar.vue'
import DataTable from '@/components/DataTable.vue'
import type { Coach } from '@/types/Coach'
import SortDropdown from '@/components/SortDropdown.vue'

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
        label: key
          .split('_')
          .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
          .join(' '),
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
