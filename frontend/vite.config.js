import { defineConfig, loadEnv } from 'vite'
import react from '@vitejs/plugin-react'

export default defineConfig(({ mode }) => {
  const env = loadEnv(mode, process.cwd(), '');

  return {
    plugins: [react()],
    server: {
      host: true, 
      port: 3000,      
      strictPort: true, 
      watch: {
        usePolling: true,
      },
      proxy: {
        '/api': {
          target: env.VITE_API_URL || 'http://backend_e2e:8000',
          changeOrigin: true,
          secure: false,
        },
      },
    },
  }
})
