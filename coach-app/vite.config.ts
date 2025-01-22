import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vitest/config'
import vue from '@vitejs/plugin-vue'
import vueDevTools from 'vite-plugin-vue-devtools'

// https://vite.dev/config/
export default defineConfig({
  plugins: [vue(), vueDevTools()],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url)),
    },
  },
  define: {
    'process.env': {}, // Make sure process.env is available if needed
  },
  test: {
    globals: true, // Enable global functions like describe, it, expect
    environment: 'jsdom', // Set jsdom as the testing environment (so document, window, etc., are available)
  },
})
