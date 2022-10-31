import { useStorage } from '@vueuse/core';
import { defineStore } from 'pinia';

export interface State {
  isAuthenticated: boolean;
  token: string | null;
}

export const useAuth = defineStore('auth', {
  state: () => ({
    isAuthenticated: useStorage('isAuthenticated', false),
    token: useStorage('token', null),
  }),
  getters: {
    isAuth: (state) => state.isAuthenticated,
    getToken: (state) => state.token,
  },
  actions: {
    setLogin(token: string) {
      this.isAuthenticated = true;
      this.token = token;
    },
    logout() {
      this.isAuthenticated = false;
      this.token = null;
    },
  },
});
