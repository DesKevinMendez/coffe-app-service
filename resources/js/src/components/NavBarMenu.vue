<script setup>
import { computed, ref, onMounted, onBeforeUnmount } from 'vue'
import { mdiChevronUp, mdiChevronDown } from '@mdi/js'
import NavBarItem from '@/components/NavBarItem.vue'
import BaseIcon from '@/components/BaseIcon.vue'

const isDropdownActive = ref(false)

const toggleDropdownIcon = computed(() => isDropdownActive.value ? mdiChevronUp : mdiChevronDown)

const toggle = () => {
  isDropdownActive.value = !isDropdownActive.value
}

const root = ref(null)

const forceClose = event => {
  if (!root.value.$el.contains(event.target)) {
    isDropdownActive.value = false
  }
}

onMounted(() => {
  window.addEventListener('click', forceClose)
})

onBeforeUnmount(() => {
  window.removeEventListener('click', forceClose)
})
</script>

<template>
  <NavBarItem
    ref="root"
    type="block"
    :active="isDropdownActive"
    dropdown
    @click="toggle"
  >
    <a class="flex items-center py-2 px-3 bg-gray-100 dark:bg-gray-800 lg:bg-transparent lg:dark:bg-transparent">
      <slot />
      <BaseIcon
        :path="toggleDropdownIcon"
        class="hidden lg:inline-flex"
      />
    </a>
    <div
      class="text-sm border-gray-100 border-b lg:border-b-0 lg:border-gray-200 lg:bg-gray-50 lg:absolute
          lg:top-full lg:left-0 lg:min-w-full lg:z-20 lg:shadow lg:rounded-b lg:dark:bg-slate-800dark:border-slate-700"
      :class="{'lg:hidden':!isDropdownActive}"
    >
      <slot name="dropdown" />
    </div>
  </NavBarItem>
</template>
