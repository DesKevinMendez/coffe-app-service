<script setup>
import { buttonMenuOptions } from '@/core/sampleButtonMenuOptions.js'
import { mdiCog } from '@mdi/js'
import PillTagTrend from '@/components/template/PillTagTrend.vue'
import BaseLevel from '@/components/template/BaseLevel.vue'
import ButtonMenu from '@/components/template/ButtonMenu.vue'

defineProps({
  trend: {
    type: String,
    default: null
  },
  trendType: {
    type: String,
    default: null
  }
})
</script>

<template>
  <BaseLevel
    v-if="trend"
    class="mb-3"
    mobile
  >
    <PillTagTrend
      :trend="trend"
      :trend-type="trendType"
      small
    />
    <ButtonMenu
      :options="buttonMenuOptions"
      :icon="mdiCog"
      small
    />
  </BaseLevel>
</template>
