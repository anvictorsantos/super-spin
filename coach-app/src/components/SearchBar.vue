<template>
  <input
    type="text"
    class="search-bar"
    placeholder="Search by name or location..."
    @input="onInput"
  />
</template>

<script lang="ts">
import { defineComponent } from 'vue'

export default defineComponent({
  name: 'SearchBar',
  emits: ['search'],
  setup(_, { emit }) {
    const onInput = (event: Event) => {
      const target = event.target as HTMLInputElement
      emit('search', target.value)
    }

    return { onInput }
  },
})
</script>

<style scoped>
.search-bar {
  width: 100%;
  padding: 0.5rem;
  margin: 1rem 0;
  border: 1px solid #ccc;
  border-radius: 4px;
}
</style>
