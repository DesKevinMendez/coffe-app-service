import { useFetch, UseFetchOptions } from '@vueuse/core'

const options: UseFetchOptions = {
  async beforeFetch({ options }) {
    options.headers = {
      ...options.headers,
      'Accept': 'application/json'
    }
    return {
      options,
    }
  },
}

export default function useRequest() {
  const get = async <T = unknown>(url: string) => {
    const { data } = useFetch<T>(url, {
      ...options,
    })
    return { data }
  }

  const post = async <T = unknown>(url: string, body: unknown) => {
    const { data } = useFetch<T>(url, {
      ...options
    }).post(body)

    return { data }
  }

  return { get, post }
}