/* eslint-env node */

const colors = require('tailwindcss/colors')
const plugin = require('tailwindcss/plugin')

module.exports = {
  content: [
    './public/index.html',
    './src/**/*.{vue,js,ts,jsx,tsx}'
  ],
  darkMode: 'class',
  theme: {
    asideScrollbars: {
      light: 'light',
      gray: 'gray'
    },
    extend: {
      spacing: {
        '22': '5.5rem'
      },
      zIndex: {
        '-1': '-1',
        100: '100'
      },
      flexGrow: {
        5: '5'
      },
      height: {
        'screen-menu': 'calc(100vh - 3.5rem)'
      },
      maxHeight: {
        'screen-menu': 'calc(100vh - 3.5rem)',
        modal: 'calc(100vh - 160px)'
      },
      transitionProperty: {
        position: 'right, left, top, bottom, margin, padding',
        size: 'width, height',
        backgroundImage: 'background-image'
      },
      margin: {
        '2.5px': '2.5px'
      },
      keyframes: {
        shake: {
          'from, to': { transform: 'translate3d(0, 0, 0)' },
          '10%, 30%, 50%, 70%, 90%': { transform: 'translate3d(-10px, 0, 0)' },
          '20%, 40%, 60%, 80%': { transform: 'translate3d(10px, 0, 0)' }
        },
        'fade-in-up': {
          from: { opacity: 0, transform: 'translate3d(0, 100%, 0)' },
          to: { opacity: 1, transform: 'none' }
        },
        'fade-out': {
          from: { opacity: 1 },
          to: { opacity: 0 }
        },
        'fade-in': {
          from: { opacity: 0 },
          to: { opacity: 1 }
        },
        'fade-in-left': {
          from: {
            opacity: '0',
            transform: 'translate3d(-50%, 0, 0)',
          },
          to: {
            opacity: 1,
            transform: 'translate3d(0, 0, 0)'
          }
        },
        'fade-in-right': {
          from: {
            opacity: '0',
            transform: 'translate3d(50%, 0, 0)',
          },
          to: {
            opacity: 1,
            transform: 'translate3d(0, 0, 0)'
          }
        },
        'slide-in-left': {
          from: {
            transform: 'translate3d(-30%, 0, 0)',
            visibility: 'visible'
          },
          to: {
            transform: 'translate3d(0, 0, 0)'
          }
        }
      },
      animation: {
        shake: 'shake 500ms ease-in-out',
        'fade-in-up-fast': 'fade-in-up 150ms ease-in-out',
        'fade-out': 'fade-out 250ms ease-in-out',
        'fade-in': 'fade-in 250ms ease-in-out',
        'fade-in-fast': 'fade-in 150ms ease-in-out',
        'slide-in-left-fast': 'slide-in-left 150ms ease-in-out',
        'fade-in-left-fast': 'fade-in-left 150ms ease-in-out',
        'fade-in-right-fast': 'fade-in-right 150ms ease-in-out'
      },
      boxShadow: {
        'r-gray-900': `1px 0 ${colors.gray[900]}`,
        'r-gray-100': `1px 0 ${colors.gray[100]}`
      }
    }
  },
  plugins: [
    require('@tailwindcss/forms'),
    plugin(function ({ matchUtilities, theme }) {
      matchUtilities(
        {
          'aside-scrollbars': value => {
            const track = value === 'light' ? '50' : '900'
            const thumb = value === 'light' ? '300' : '600'
            const color = value === 'light' ? 'gray' : value

            return {
              scrollbarWidth: 'thin',
              scrollbarColor: `${theme(`colors.${color}.${thumb}`)} ${theme(`colors.${color}.${track}`)}`,
              '&::-webkit-scrollbar': {
                width: '8px',
                height: '8px'
              },
              '&::-webkit-scrollbar-track': {
                backgroundColor: theme(`colors.${color}.${track}`)
              },
              '&::-webkit-scrollbar-thumb': {
                borderRadius: '0.25rem',
                backgroundColor: theme(`colors.${color}.${thumb}`)
              }
            }
          }
        },
        { values: theme('asideScrollbars') }
      )
    }),
    require('@tailwindcss/line-clamp')
  ]
}
