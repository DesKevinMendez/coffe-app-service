import {
  mdiAccountCircle,
  mdiDesktopMac,
  mdiHelpCircle,
  mdiLock,
  mdiSquareEditOutline,
  mdiTable,
  mdiMenuOpen,
  mdiTelevisionGuide,
  mdiBarcode,
  mdiThemeLightDark,
  mdiPalette,
  mdiCardAccountDetailsOutline, 
  mdiOpenInNew,
  mdiFormDropdown
} from '@mdi/js'

export default [
  {
    to: '/',
    icon: mdiDesktopMac,
    label: 'Dashboard'
  },
  {
    label: 'Dark mode',
    icon: mdiThemeLightDark,
    darkModeToggle: true
  },
  {
    to: '/profile',
    label: 'Profile',
    icon: mdiAccountCircle,
  },
  {
    to: '/login',
    label: 'Login',
    icon: mdiLock
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
