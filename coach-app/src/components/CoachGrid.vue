<template>
  <div class="coach-grid">
    <CoachCard v-for="coach in coaches" :key="coach.id" :coach="coach" />
  </div>
</template>

<script lang="ts">
import { defineComponent, type PropType } from 'vue'
import type { Coach } from '@/types/Coach'
import CoachCard from '@/components/CoachCard.vue'

export default defineComponent({
  name: 'CoachGrid',
  components: { CoachCard },
  props: {
    coaches: {
      type: Array as PropType<Coach[]>,
      required: true,
    },
  },
})
</script>

<style scoped>
.coach-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 1rem;
}
</style>
