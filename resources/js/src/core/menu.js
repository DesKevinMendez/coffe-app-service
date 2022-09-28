import {
  mdiAccountCircle,
  mdiDesktopMac,
  mdiLock,
  mdiMenuOpen,
  mdiCardAccountDetailsOutline, 
} from '@mdi/js'

export default [
  {
    to: '/',
    icon: mdiDesktopMac,
    label: 'Dashboard'
  },
  {
    to: '/profile',
    label: 'Profile',
    icon: mdiAccountCircle,
  },
  {
    // Key should be unique for each submenus object
    // It is required for open/close logic
    key: 'submenus-1',
    label: 'Sub',
    icon: mdiMenuOpen,
    menuSecondary: [
      {
        to: '/profile',
        label: 'Permanentes',
        icon: mdiCardAccountDetailsOutline 
      },
      {
        to: '/profile',
        label: 'Temporales',
        icon: mdiCardAccountDetailsOutline 
      },
    ]
  },
]
