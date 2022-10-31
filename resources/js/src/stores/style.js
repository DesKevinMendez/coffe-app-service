import { defineStore } from 'pinia';
import * as styles from '@/core/styles';
import { darkModeKey, styleKey } from '@/core/config';

export const useStyleStore = defineStore('style', {
  state: () => ({
    /* Styles */
    style: '',
    asideStyle: '',
    asideScrollbarsStyle: '',
    asideBrandStyle: '',
    asideExpandCollapseStyle: '',
    asideMenuItemStyle: '',
    asideMenuItemActiveStyle: '',
    asideMenuItemActiveBgStyle: '',
    asideMenuItemInactiveStyle: '',
    asideSubmenuListStyle: '',
    navBarItemLabelStyle: '',
    navBarItemLabelHoverStyle: '',
    navBarItemLabelActiveColorStyle: '',
    overlayStyle: '',

    /* Dark mode */
    darkMode: false,
  }),
  actions: {
    setStyle(payload) {
      if (!styles[payload]) {
        return;
      }

      this.style = payload;

      const style = styles[payload];

      if (typeof localStorage !== 'undefined') {
        localStorage.setItem(styleKey, payload);
      }

      for (const key in style) {
        this[`${key}Style`] = style[key];
      }
    },

    setDarkMode(payload = null) {
      this.darkMode = payload !== null ? payload : !this.darkMode;

      if (typeof document !== 'undefined') {
        document.documentElement.classList[this.darkMode ? 'add' : 'remove'](
          'dark-scrollbars'
        );
      }

      if (typeof localStorage !== 'undefined') {
        localStorage.setItem(darkModeKey, this.darkMode ? '1' : '0');
      }
    },
  },
});
