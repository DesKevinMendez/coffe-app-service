<script setup>
import { buttonMenuOptions } from '@/core/sampleButtonMenuOptions.js';
import { mdiMenu } from '@mdi/js';
import { useSlots, computed } from 'vue';
import BaseIcon from '@/components/template/BaseIcon.vue';
import ButtonMenu from '@/components/template/ButtonMenu.vue';
import IconRounded from './IconRounded.vue';

defineProps({
  icon: {
    type: String,
    default: null,
  },
  title: {
    type: String,
    required: true,
  },
  main: Boolean,
});

const hasSlot = computed(() => useSlots().default);
</script>

<template>
  <section
    :class="{ 'pt-6': !main }"
    class="mb-6 flex items-center justify-between"
  >
    <div class="flex items-center justify-start">
      <IconRounded
        v-if="icon && main"
        :icon="icon"
        type="light"
        class="mr-3"
        bg
      />
      <BaseIcon v-else-if="icon" :path="icon" class="mr-2" size="20" />
      <h1 :class="main ? 'text-3xl' : 'text-2xl'" class="leading-tight">
        {{ title }}
      </h1>
    </div>
    <slot v-if="hasSlot" />
    <ButtonMenu v-else :options="buttonMenuOptions" :icon="mdiMenu" small />
  </section>
</template>
