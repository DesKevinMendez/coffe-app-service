import { defineStore } from 'pinia'

export interface State {
  isAuthenticated: boolean;
  token: string | null;
}

const initialState: State = {
  isAuthenticated: false,
  token: null
}
export const useAuth = defineStore('auth', {
  state: (): State => ({ ...initialState }),
  getters: {
    isAuth: (state) => state.isAuthenticated,
    getToken: (state) => state.token
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
  }
})