import { createApp } from 'vue';
import { createPinia } from 'pinia';

import App from '../App.vue';
import router from '../router';
import { useLayoutStore } from '@/stores/layout';
import { useStyleStore } from '@/stores/style';
import { darkModeKey, styleKey } from '@/core/config';
import './veeValidate';
import './../../../css/app.css';

/* Init Pinia */
const pinia = createPinia();

/* Create Vue app */
createApp(App).use(router).use(pinia).mount('#app');

/* Init Pinia stores */
const layoutStore = useLayoutStore(pinia);
const styleStore = useStyleStore(pinia);

/* Responsive layout control */
layoutStore.responsiveLayoutControl();
window.onresize = () => layoutStore.responsiveLayoutControl();

/* App style */
styleStore.setStyle(localStorage[styleKey] ?? 'white');

/* Dark mode */
if (
  (!localStorage[darkModeKey] &&
    window.matchMedia('(prefers-color-scheme: dark)').matches) ||
  localStorage[darkModeKey] === '1'
) {
  styleStore.setDarkMode(true);
}

/* Default title tag */
const defaultDocumentTitle = 'Admin One Vue 3 Tailwind';

/* Collapse mobile aside menu on route change */
router.beforeEach(() => {
  layoutStore.asideMobileToggle(false);
  layoutStore.asideCompactToggle(true);
  layoutStore.secondaryMenu = null;
});

router.afterEach((to) => {
  /* Set document title from route meta */
  if (to.meta && to.meta.title) {
    document.title = `${to.meta.title} — ${defaultDocumentTitle}`;
  } else {
    document.title = defaultDocumentTitle;
  }

  layoutStore.responsiveLayoutControl();
});
