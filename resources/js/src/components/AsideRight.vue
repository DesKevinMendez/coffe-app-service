<script setup>
import { computed } from 'vue'
import { useMainStore } from '@/stores/main.js'
import { useLayoutStore } from '@/stores/layout.js'
import AsideRightItem from '@/components/AsideRightItem.vue'

const layoutStore = useLayoutStore()

const items = computed(() => useMainStore().updates)
</script>

<template>
  <aside
    id="aside-right"
    class="w-60 pr-1.5 fixed z-40 h-screen lg:h-screen-menu top-0 lg:top-14 bg-white overflow-y-auto overflow-x-hidden
    transition-position dark:bg-slate-900 shadow-xl"
    :class="layoutStore.isAsideRightActive ? 'right-0' : '-right-60'"
  >
    <AsideRightItem
      v-for="item in items"
      :key="item.id"
      :text="item.text"
      :status="item.status"
      :ago="item.ago"
    />
  </aside>
</template>
