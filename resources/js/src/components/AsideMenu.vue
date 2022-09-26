<script setup>
import { mdiChevronRightCircleOutline, mdiChevronLeftCircleOutline } from '@mdi/js'
import { computed } from 'vue'
import { useLayoutStore } from '@/stores/layout.js'
import { useStyleStore } from '@/stores/style.js'
import AsideMenuList from '@/components/AsideMenuList.vue'
import AsideMenuItem from '@/components/AsideMenuItem.vue'

const props = defineProps({
  menu: {
    type: Array,
    default: () => []
  },
  zIndex: {
    type: String,
    default: 'z-50'
  },
  compact: Boolean,
  isSecondary: Boolean
})

const emit = defineEmits(['menu-click'])

const layoutStore = useLayoutStore()

const styleStore = useStyleStore()

const expandCollapseItem = computed(() => ({
  label: props.compact ? 'Exapand' : 'Collapse',
  icon: props.compact ? mdiChevronRightCircleOutline : mdiChevronLeftCircleOutline,
  color: styleStore.asideExpandCollapseStyle
}))

const expandCollapseClick = () => {
  layoutStore.asideCompactToggle()
}

const menuClick = (event, item) => {
  emit('menu-click', event, item)
}
</script>

<template>
  <aside
    v-show="layoutStore.isAsideVisible"
    id="aside"
    :class="zIndex"
    class="lg:py-2 lg:pl-2 flex w-64 fixed top-0 h-screen transition-position overflow-hidden"
  >
    <div
      :class="styleStore.asideStyle"
      class="lg:rounded-xl flex-1 flex flex-col overflow-hidden dark:bg-slate-900"
    >
      <div
        :class="styleStore.asideBrandStyle"
        class="flex flex-row w-full shrink-0 h-14 items-center dark:bg-slate-900"
      >
        <slot />
      </div>
      <div
        :class="styleStore.asideScrollbarsStyle" 
        class="flex-1 overflow-y-auto overflow-x-hidden"
      >
        <AsideMenuList
          :menu="menu"
          :compact="compact"
          @menu-click="menuClick"
        />
      </div>

      <ul
        v-if="!isSecondary"
        class="hidden lg:block"
      >
        <AsideMenuItem
          :item="expandCollapseItem"
          :compact="compact"
          @menu-click="expandCollapseClick"
        />
      </ul>
    </div>
  </aside>
</template>
