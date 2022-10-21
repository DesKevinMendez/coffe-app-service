import { useFetch } from '@/utils/useMyFetch'

export default function useRequest() {
  const get = async <T = unknown>(url: string) => {
    const { data } = useFetch<T>(url)
    return { data }
  }

  const post = async <T = unknown>(url: string, body: unknown) => {
    const { data } = useFetch<T>(url).post(body)
    return { data }
  }

  return { get, post }
}