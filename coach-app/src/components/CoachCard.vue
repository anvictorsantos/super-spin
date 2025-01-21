<template>
  <div class="coach-card">
    <h3>{{ coach.name }}</h3>
    <p><strong>Experience:</strong> {{ coach.years_of_experience }} years</p>
    <p><strong>Rate:</strong> ${{ coach.hourly_rate }}/hr</p>
    <p><strong>Location:</strong> {{ coach.location }}</p>
    <p><strong>Joined:</strong> {{ formattedDate }}</p>
  </div>
</template>

<script lang="ts">
import { defineComponent, type PropType } from 'vue'
import type { Coach } from '@/types/Coach'

export default defineComponent({
  name: 'CoachCard',
  props: {
    coach: {
      type: Object as PropType<Coach>,
      required: true,
    },
  },
  computed: {
    formattedDate() {
      return new Date(this.coach.joined_at).toLocaleDateString()
    },
  },
})
</script>

<style scoped>
.coach-card {
  border: 1px solid #ccc;
  border-radius: 8px;
  padding: 1rem;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}
</style>
