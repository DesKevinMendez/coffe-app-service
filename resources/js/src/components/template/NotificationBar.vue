<script setup>
import { ref, computed, useSlots } from 'vue';
import { useMainStore } from '@/stores/main';
import { mdiClose } from '@mdi/js';
import { colorsBgLight, colorsOutline } from '@/core/colors';
import BaseLevel from '@/components/template/BaseLevel.vue';
import BaseIcon from '@/components/template/BaseIcon.vue';
import BaseButton from '@/components/template/BaseButton.vue';

const props = defineProps({
  icon: {
    type: String,
    default: null,
  },
  outline: Boolean,
  color: {
    type: String,
    required: true,
  },
});

const mainStore = useMainStore();

const componentClass = computed(() =>
  props.outline ? colorsOutline[props.color] : colorsBgLight[props.color]
);

const isDismissed = ref(false);

const dismiss = () => {
  isDismissed.value = true;
  mainStore.pushMessage('Done! Notification Dismissed');
};

const slots = useSlots();

const hasRightSlot = computed(() => slots.right);
</script>

<template>
  <div
    v-if="!isDismissed"
    :class="componentClass"
    class="px-3 py-6 md:py-3 mx-6 md:mx-0 mb-6 last:mb-0 border rounded transition-colors duration-150"
  >
    <BaseLevel>
      <div class="flex flex-col md:flex-row items-center">
        <BaseIcon
          v-if="icon"
          :path="icon"
          w="w-8 md:w-5"
          h="h-8 md:h-5"
          size="96"
          class="mb-3 md:mb-0 md:mr-2"
        />
        <span class="text-center md:text-left"><slot /></span>
      </div>
      <slot v-if="hasRightSlot" name="right" />
      <BaseButton
        v-else
        :icon="mdiClose"
        :outline="outline"
        small
        @click="dismiss"
      />
    </BaseLevel>
  </div>
</template>
