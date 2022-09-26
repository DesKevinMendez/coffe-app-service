<script setup>
import { mdiCircleSlice8, mdiCheckboxBlankCircleOutline } from '@mdi/js'
import { computed } from 'vue'
import { useStyleStore } from '@/stores/style.js'
import BaseButtons from '@/components/BaseButtons.vue'
import BaseButton from '@/components/BaseButton.vue'

defineProps({
  useLabel: Boolean
})

const styleStore = useStyleStore()

const currentStyle = computed(() => styleStore.style)

const setStyle = style => {
  styleStore.setStyle(style)
  styleStore.setDarkMode(false)
}

const styles = {
  white: 'white',
  basic: 'bg-gray-500 hover:bg-gray-600',
  slate: 'bg-slate-500 hover:bg-slate-600',
  zinc: 'bg-zinc-500 hover:bg-zinc-600',
  neutral: 'bg-neutral-500 hover:bg-neutral-600',
  stone: 'bg-stone-500 hover:bg-stone-600',
  emerald: 'bg-emerald-500 hover:bg-emerald-600',
  teal: 'bg-teal-500 hover:bg-teal-600',
  cyan: 'bg-cyan-500 hover:bg-cyan-600',
  sky: 'bg-sky-500 hover:bg-sky-600',
  blue: 'bg-blue-500 hover:bg-blue-600',
  indigo: 'bg-indigo-500 hover:bg-indigo-600',
  violet: 'bg-violet-500 hover:bg-violet-600',
  purple: 'bg-purple-500 hover:bg-purple-600',
  fuchsia: 'bg-fuchsia-500 hover:bg-fuchsia-600',
  pink: 'bg-pink-500 hover:bg-pink-600',
  rose: 'bg-rose-500 hover:bg-rose-600'
}
</script>

<template>
  <div>
    <BaseButtons type="justify-center">
      <BaseButton
        v-for="(styleBg, style) in styles"
        :key="style"
        :color="style === 'white' ? style : `${styleBg} text-white`"
        :icon="style !== currentStyle ? mdiCheckboxBlankCircleOutline : mdiCircleSlice8"
        :label="useLabel ? style : null"
        class="capitalize"
        @click="setStyle(style)"
      />
    </BaseButtons>
  </div>
</template>
