import { useFetch } from '@/utils/useMyFetch';

export default function useRequest() {
  const get = async <T = unknown>(url: string) => {
    const { data } = await useFetch<T>(url, {
      afterFetch(ctx) {
        return { ...ctx, data: JSON.parse(ctx.data) };
      },
    });
    return { data };
  };

  const post = async <T = unknown>(url: string, body: unknown) => {
    const { data, error, statusCode, isFinished } = await useFetch<T>(url, {
      afterFetch(ctx) {
        return { ...ctx, data: JSON.parse(ctx.data) };
      },
    }).post(body);

    return { data, error, statusCode, isFinished };
  };

  return { get, post };
}
