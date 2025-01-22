<template>
  <input
    type="text"
    class="search-bar"
    placeholder="Search by name or location..."
    @input="onInput"
  />
</template>

<script setup lang="ts">
import { defineEmits } from 'vue'

// Define emits using defineEmits
const emit = defineEmits<{
  (e: 'search', query: string): void
}>()

// Event handler for the input field
const onInput = (event: Event) => {
  const target = event.target as HTMLInputElement
  emit('search', target.value) // Emit the search query
}
</script>
