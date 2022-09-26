import { defineStore } from 'pinia'

export const useLayoutStore = defineStore('layout', {
  state: () => ({
    /* Aside */
    isAsideVisible: true,
    isAsideCompact: true,
    isAsideMobileExpanded: false,
    secondaryMenu: null,

    /* AsideRight */
    isAsideRightActive: false,

    /* Breakpoints */
    isXl: false,
    isLg: false,
    isMd: false,
  }),
  actions: {
    asideCompactToggle (payload = null) {
      this.isAsideCompact = payload !== null ? payload : !this.isAsideCompact
    },

    asideRightToggle (payload = null) {
      this.isAsideRightActive = payload !== null ? payload : !this.isAsideRightActive
    },

    asideMobileToggle (payload = null) {
      this.isAsideMobileExpanded = payload !== null ? payload : !this.isAsideMobileExpanded
    },

    responsiveLayoutControl () {
      this.isXl = window.innerWidth >= 1280
      this.isLg = window.innerWidth >= 1024
      this.isMd = window.innerWidth >= 768
    }
  }
})
