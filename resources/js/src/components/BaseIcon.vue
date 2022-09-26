<script setup>
import { computed } from 'vue'
import IconUpdateMark from '@/components/IconUpdateMark.vue'

const props = defineProps({
  path: {
    type: String,
    required: true
  },
  w: {
    type: String,
    default: 'w-6'
  },
  h: {
    type: String,
    default: 'h-6'
  },
  size: {
    type: [String, Number],
    default: 16
  },
  updateMark: {
    type: String,
    default: null
  },
  updateMarkTr: {
    type: String,
    default: null
  }
})

const svgSize = computed(() => {
  return props.size ?? 16
})
</script>

<template>
  <span
    class="inline-flex justify-center items-center" 
    :class="[w, h, {'relative': updateMark}]"
  >
    <svg
      viewBox="0 0 24 24"
      :width="svgSize"
      :height="svgSize"
      class="inline-block"
    >
      <path
        fill="currentColor"
        :d="path"
      />
    </svg>
    <IconUpdateMark
      :color="updateMark"
      :tr="updateMarkTr"
    />
  </span>
</template>
