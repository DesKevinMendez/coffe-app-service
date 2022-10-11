<script setup>
import { computed } from 'vue'
import { useLayoutStore } from '@/stores/layout.js'
import { useStyleStore } from '@/stores/style.js'
import { mdiClose } from '@mdi/js'
import menu from '@/core/menu.js'
import BaseIcon from '@/components/template/BaseIcon.vue'
import NavBar from '@/components/template/NavBar.vue'
import AsideMenu from '@/components/template/AsideMenu.vue'
import AsideRight from '@/components/template/AsideRight.vue'
import FooterBar from '@/components/template/FooterBar.vue'
import OverlayLayer from '@/components/template/OverlayLayer.vue'
import SnackBar from '@/components/template/SnackBar.vue'

const layoutStore = useLayoutStore()

const styleStore = useStyleStore()

const isAsideCompact = computed(() => layoutStore.isAsideCompact)

const isAsideMobileExpanded = computed(() => layoutStore.isAsideMobileExpanded)

const isOverlayVisible = computed(() => secondaryMenuItem.value || !isAsideCompact.value)

const secondaryMenuItem = computed(() => layoutStore.secondaryMenu)

const secondaryMenuClose = () => {
  layoutStore.secondaryMenu = null
}

const menuClick = (event, item) => {
  if (item.darkModeToggle) {
    styleStore.setDarkMode()
  }

  if (item.menuSecondary) {
    if (secondaryMenuItem.value && item.key === secondaryMenuItem.value.key) {
      secondaryMenuClose()
    } else {
      layoutStore.secondaryMenu = item
    }
  }
}

const overlayClick = () => {
  if (secondaryMenuItem.value) {
    secondaryMenuClose()
  } else if (!isAsideCompact.value) {
    layoutStore.asideCompactToggle(true)
  }
}

window.addEventListener('keydown', e => {
  if (e.key === 'Escape' && (secondaryMenuItem.value || !isAsideCompact.value)) {
    overlayClick()
  }
})
</script>

<template>
  <div
    :class="{ 'dark': styleStore.darkMode,
              'overflow-hidden lg:overflow-visible': layoutStore.isAsideMobileExpanded }">
    <div
      :class="{ 'ml-64 lg:ml-0': layoutStore.isAsideMobileExpanded,
                '-ml-60 lg:ml-0': layoutStore.isAsideRightActive }" 
      class="text-base bg-gray-50 dark:bg-slate-800
      dark:text-gray-100 pt-14 lg:pl-22 w-screen transition-position lg:w-auto min-h-screen relative"
    >
      <NavBar
        :class="{ 'ml-64 lg:ml-0': layoutStore.isAsideMobileExpanded,
                  '-ml-60 lg:ml-0': layoutStore.isAsideRightActive }" />
      <AsideMenu
        :menu="menu"
        :class="{ '-left-64 lg:left-0': !isAsideMobileExpanded,
                  'left-0': isAsideMobileExpanded, 'lg:w-22':isAsideCompact }"
        :compact="isAsideCompact"
        :z-index="secondaryMenuItem ? 'z-40 md:z-50' : 'z-50'"
        @menu-click="menuClick"
      >
        <div
          class="flex-1 px-3 flex justify-center"
        >
          <b class="font-black">One</b>
        </div>
      </AsideMenu>
      <AsideMenu
        v-if="secondaryMenuItem"
        :menu="secondaryMenuItem.menuSecondary"
        :class="{ 'md:left-64':!isAsideCompact, 'lg:left-22':isAsideCompact }"
        class="right-0 md:right-auto animate-fade-in-right-fast lg:animate-fade-in-left-fast"
        is-secondary
      >
        <BaseIcon
          v-if="secondaryMenuItem.icon"
          :path="secondaryMenuItem.icon"
          w="w-16"
        />
        <div class="flex-1">
          {{ secondaryMenuItem.label }}
        </div>
        <BaseIcon
          :path="mdiClose"
          class="cursor-pointer"
          w="w-12"
          @click="secondaryMenuClose"
        />
      </AsideMenu>
      <AsideRight />
      <slot />
      <FooterBar />
      <OverlayLayer
        v-show="isOverlayVisible"
        z-index="z-40"
        @overlay-click="overlayClick"
      />
      <SnackBar />
    </div>
  </div>
</template>
