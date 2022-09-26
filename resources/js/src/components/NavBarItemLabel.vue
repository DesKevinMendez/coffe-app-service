<script setup>
import BaseIcon from '@/components/BaseIcon.vue'

defineProps({
  icon: {
    type: String,
    required: true
  },
  label: {
    type: String,
    required: true
  },
  isDesktopIconOnly: Boolean,
  updateMark: {
    type: String,
    default: null
  }
})
</script>

<template>
  <BaseIcon
    :path="icon"
    class="transition-colors"
    :update-mark="updateMark"
  />
  <span
    class="px-2 transition-colors"
    :class="{'lg:hidden':isDesktopIconOnly}"
  >{{ label }}</span>
</template>
