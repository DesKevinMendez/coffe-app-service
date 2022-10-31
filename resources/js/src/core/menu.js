import {
  mdiCart,
  mdiDesktopMac,
  mdiCoffeeMaker,
  mdiBucketOutline,
  mdiAccountMultiple,
} from '@mdi/js';

export default [
  {
    to: '/',
    icon: mdiDesktopMac,
    label: 'Inicio',
  },
  {
    to: '/orders',
    label: 'Ordenes',
    icon: mdiCart,
  },
  {
    to: '/sales',
    label: 'Ventas',
    icon: mdiBucketOutline,
  },
  {
    to: '/products',
    label: 'Productos',
    icon: mdiCoffeeMaker,
  },
  {
    to: '/users',
    label: 'Usuarios',
    icon: mdiAccountMultiple,
  },
];
