<script setup>
import { computed } from 'vue'
import { useMainStore } from '@/stores/main.js'
import SnackBarItem from '@/components/SnackBarItem.vue'

defineProps({
  active: Boolean
})

const mainStore = useMainStore()

const messages = computed(() => mainStore.messages)

const expired = () => {
  mainStore.shiftMessage()
}
</script>

<template>
  <div class="fixed inset-0 flex flex-col-reverse p-9 overflow-hidden z-100 pointer-events-none">
    <SnackBarItem
      v-for="message in messages"
      :key="message.ts"
      :active="true"
      :message="message"
      @expired="expired"
    />
  </div>
</template>
