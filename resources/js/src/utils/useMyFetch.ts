import { createFetch, CreateFetchOptions } from "@vueuse/core"
const baseUrl = import.meta.env.VITE_BASE_URL

const options: CreateFetchOptions = {
  baseUrl,
  options: {
    async beforeFetch({ options }) {
      options.headers = {
        ...options.headers,
        'Accept': 'application/json'
      }
      return {
        options,
      }
    }
  },
}
export const useFetch = createFetch({...options,})