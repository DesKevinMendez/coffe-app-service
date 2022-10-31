<script setup>
import { colorsBgLight } from '@/core/colors';
import { mdiInformation } from '@mdi/js';
import BaseIcon from '@/components/template/BaseIcon.vue';

defineProps({
  text: {
    type: String,
    required: true,
  },
  status: {
    type: String,
    required: true,
    validator(value) {
      return ['success', 'info', 'warning', 'danger'].includes(value);
    },
  },
  ago: {
    type: String,
    required: true,
  },
});
</script>

<template>
  <div
    class="p-6 border-b border-gray-100 last:border-b-0 dark:border-slate-800"
  >
    <div class="mb-3">
      {{ text }}
    </div>
    <div class="flex justify-start">
      <div
        class="inline-flex rounded-sm text-white"
        :class="colorsBgLight[status]"
      >
        <BaseIcon :path="mdiInformation" />
      </div>
      <div class="text-sm text-gray-500 ml-3 dark:text-gray-400">
        {{ ago }}
      </div>
    </div>
  </div>
</template>
