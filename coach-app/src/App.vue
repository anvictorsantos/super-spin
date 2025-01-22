<template>
  <div id="app">
    <header>
      <h1>SuperSpin Coaches</h1>
      <SearchBar @search="handleSearch" />
      <SortDropdown @sort="handleSort" />
    </header>
    <main>
      <div v-if="loading">Loading...</div>
      <div v-else-if="error" class="error">{{ error }}</div>
      <DataTable :fields="fields" :data="filteredCoaches" />
    </main>
  </div>
</template>

<script lang="ts">
import { ref, computed, onMounted } from 'vue'
import apiClient from '@/services/axios' // Import the Axios instance
import SearchBar from '@/components/SearchBar.vue'
import SortDropdown from '@/components/SortDropdown.vue'
import DataTable from '@/components/DataTable.vue'
import type { Coach } from '@/types/Coach'

export default {
  name: 'App',
  components: { SearchBar, SortDropdown, DataTable },
  setup() {
    const coaches = ref<Coach[]>([])
    const loading = ref(true)
    const error = ref<string | null>(null)
    const searchQuery = ref('')
    const sortOption = ref<'asc' | 'desc' | null>(null)
    const fields = [
      { key: 'id', label: 'ID' },
      { key: 'name', label: 'Name' },
      { key: 'years_of_experience', label: 'Years of Experience' },
      { key: 'hourly_rate', label: 'Hourly Rate' },
      { key: 'hourly_rate', label: 'Hourly Rate' },
      { key: 'location', label: 'Location' },
      { key: 'joined_at', label: 'Joined At' },
    ]

    const fetchCoaches = async () => {
      try {
        const response = await apiClient.get('/coaches') // Use the Axios instance
        coaches.value = response.data
      } catch (err) {
        error.value = 'Failed to load coaches. Please try again later.'
      } finally {
        loading.value = false
      }
    }

    const filteredCoaches = computed(() => {
      let result = [...coaches.value]

      if (searchQuery.value) {
        const query = searchQuery.value.toLowerCase()
        result = result.filter(
          (coach) =>
            coach.name.toLowerCase().includes(query) ||
            coach.location.toLowerCase().includes(query),
        )
      }

      if (sortOption.value === 'asc') {
        result.sort((a, b) => a.hourly_rate - b.hourly_rate)
      } else if (sortOption.value === 'desc') {
        result.sort((a, b) => b.hourly_rate - a.hourly_rate)
      }

      return result
    })

    const handleSearch = (query: string) => {
      searchQuery.value = query
    }

    const handleSort = (option: 'asc' | 'desc' | null) => {
      sortOption.value = option
    }

    onMounted(fetchCoaches)

    return {
      coaches,
      filteredCoaches,
      loading,
      error,
      handleSearch,
      handleSort,
      fields,
    }
  },
}
</script>
