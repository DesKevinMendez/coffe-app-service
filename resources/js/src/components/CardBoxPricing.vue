<script setup>
import { mdiCheck } from '@mdi/js'
import CardBox from '@/components/CardBox.vue'
import BaseButtons from '@/components/BaseButtons.vue'
import BaseButton from '@/components/BaseButton.vue'
import PillTag from '@/components/PillTag.vue'
import BaseLevel from '@/components/BaseLevel.vue'
import BaseIcon from '@/components/BaseIcon.vue'

defineProps({
  item: {
    type: Object,
    required: true,
    validator: value => (value.title && value.subTitle)
  },
  price: {
    type: [String, Number],
    required: true
  },
  period: {
    type: String,
    required: true
  },
  main: Boolean
})
</script>

<template>
  <CardBox
    :class="[main ? 'shadow-2xl' : 'lg:my-12']"
    rounded="rounded-2xl"
    :collapsible="!main"
    collapsed-class="hidden lg:block"
    collapsible-header-class=""
  >
    <template #header="props">
      <BaseLevel mobile>
        <div>
          <BaseLevel
            type="justify-start"
            mobile
          >
            <h3 class="text-4xl">
              $
            </h3>
            <h1 class="text-5xl font-black">
              {{ price }}
            </h1>
            <h1 class="text-xl text-gray-500 dark:text-gray-400">
              /{{ period }}
            </h1>
          </BaseLevel>
          <PillTag
            :text="item.label"
            :type="item.labelType"
            class="mt-3"
            small
          />
        </div>

        <BaseLevel mobile>
          <div class="text-right">
            <h1 class="text-2xl">
              {{ item.title }}
            </h1>
            <h1 class="text-lg text-gray-500 dark:text-gray-400">
              {{ item.subTitle }}
            </h1>
          </div>
          <BaseIcon
            v-if="props.icon"
            :path="props.icon"
            size="48"
            w="w-16"
            h="h-16"
            class="ml-6 lg:hidden"
          />
        </BaseLevel>
      </BaseLevel>
    </template>

    <div class="space-y-6">
      <div
        v-for="(option, index) in item.options"
        :key="index"
        class="flex items-center"
      >
        <BaseIcon
          :path="mdiCheck"
          size="24"
          w="w-8"
          h="h-8"
        />
        <span class="text-lg ml-3"><b>{{ option.main }}</b> {{ option.sub }}</span>
      </div>
    </div>

    <template #footer>
      <BaseButtons>
        <BaseButton
          class="flex-1"
          color="info"
          label="Subscribe"
          :outline="!main"
        />
      </BaseButtons>
    </template>
  </CardBox>
</template>
