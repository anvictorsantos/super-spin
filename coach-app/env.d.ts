/// <reference types="vite/client" />

interface ImportMetaEnv {
  readonly VITE_API_BASE_URL: string // Define the base URL type
}

interface ImportMeta {
  readonly env: ImportMetaEnv
}
