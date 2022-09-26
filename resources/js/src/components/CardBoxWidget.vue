<script setup>
import { computed } from 'vue'
import { useLayoutStore } from '@/stores/layout.js'
import CardBox from '@/components/CardBox.vue'
import NumberDynamic from '@/components/NumberDynamic.vue'
import BaseIcon from '@/components/BaseIcon.vue'
import BaseLevel from '@/components/BaseLevel.vue'
import CardBoxWidgetTrend from '@/components/CardBoxWidgetTrend.vue'

defineProps({
  number: {
    type: Number,
    default: 0
  },
  icon: {
    type: String,
    default: null
  },
  prefix: {
    type: String,
    default: null
  },
  suffix: {
    type: String,
    default: null
  },
  label: {
    type: String,
    default: null
  },
  color: {
    type: String,
    default: null
  },
  trend: {
    type: String,
    default: null
  },
  trendType: {
    type: String,
    default: null
  }
})

const layoutStore = useLayoutStore()

const smaller = computed(() => !layoutStore.isLg)
</script>

<template>
  <CardBox
    v-bind="$attrs"
    :smaller-padding="smaller"
    class="mx-6 md:mx-0"
  >
    <CardBoxWidgetTrend
      v-if="trend"
      :trend="trend"
      :trend-type="trendType"
    />
    <BaseLevel mobile>
      <div>
        <h3 class="text-lg leading-tight text-gray-500 dark:text-gray-400">
          {{ label }}
        </h3>
        <h1 class="text-3xl leading-tight font-semibold">
          <NumberDynamic
            :value="number"
            :prefix="prefix"
            :suffix="suffix"
          />
        </h1>
      </div>
      <BaseIcon
        v-if="icon"
        :path="icon"
        size="48"
        w=""
        h="h-16"
        :class="color"
      />
    </BaseLevel>
  </CardBox>
</template>
