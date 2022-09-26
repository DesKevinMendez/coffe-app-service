<script setup>
import { useMainStore } from '@/stores/main.js'
import { computed } from 'vue'
import { mdiCamera } from '@mdi/js'
import FormFilePicker from '@/components/FormFilePicker.vue'

const props = defineProps({
  username: {
    type: String,
    default: null
  },
  bg: {
    type: String,
    default: 'bg-gray-100 dark:bg-slate-800'
  },
  api: {
    type: String,
    default: 'api/avataaars'
  },
  button: Boolean
})

const mainStore = useMainStore()

const avatar = computed(() => props.username
  ? `https://avatars.dicebear.com/${props.api}/${props.username.replace(/[^a-z0-9]+/i, '-')}.svg`
  : mainStore.userAvatar)

const name = computed(() => props.username ? props.username : mainStore.userName)
</script>

<template>
  <div :class="{'relative':button}">
    <img
      :src="avatar"
      :alt="name"
      class="rounded-full block h-auto w-full max-w-full"
      :class="bg"
    >
    <div
      v-if="button"
      class="absolute right-0 bottom-0"
    >
      <FormFilePicker
        :icon="mdiCamera"
        rounded-full
      />
    </div>
  </div>
</template>
