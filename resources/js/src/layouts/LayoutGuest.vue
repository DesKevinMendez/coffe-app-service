<script setup>
import { useStyleStore } from '@/stores/style';

const styleStore = useStyleStore();
</script>

<template>
  <div :class="{ dark: styleStore.darkMode }">
    <div class="text-base dark:text-gray-100">
      <slot />
    </div>
  </div>
</template>
