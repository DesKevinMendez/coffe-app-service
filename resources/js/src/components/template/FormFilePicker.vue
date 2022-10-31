<script setup>
import { mdiCloudUpload } from '@mdi/js';
import { computed, ref, watch } from 'vue';
import BaseButton from '@/components/template/BaseButton.vue';

const props = defineProps({
  modelValue: {
    type: [Object, File, Array],
    default: null,
  },
  label: {
    type: String,
    default: 'Upload',
  },
  icon: {
    type: String,
    default: mdiCloudUpload,
  },
  accept: {
    type: String,
    default: null,
  },
  addon: Boolean,
  roundedFull: Boolean,
  small: Boolean,
  outline: Boolean,
  color: {
    type: String,
    default: 'info',
  },
});

const emit = defineEmits(['update:modelValue']);

const root = ref(null);

const file = ref(props.modelValue);

const modelValueProp = computed(() => props.modelValue);

watch(modelValueProp, (value) => {
  file.value = value;

  if (!value) {
    root.value.input.value = null;
  }
});

const upload = (event) => {
  const value = event.target.files || event.dataTransfer.files;

  file.value = value[0];

  emit('update:modelValue', file.value);
};
</script>

<template>
  <div class="flex items-stretch justify-start relative">
    <label class="inline-flex">
      <BaseButton
        as="a"
        :class="{ 'w-12 h-12': roundedFull }"
        :icon-size="roundedFull ? 24 : null"
        :rounded-full="roundedFull"
        :small="small || roundedFull"
        :label="roundedFull ? null : label"
        :icon-right="icon"
        :addon="!!(addon && file)"
        :outline="outline"
        :color="color"
      />
      <input
        ref="root"
        type="file"
        class="absolute top-0 left-0 w-full h-full opacity-0 outline-none cursor-pointer -z-1"
        :accept="accept"
        @input="upload"
      />
    </label>
    <div v-if="addon && file">
      <span class="form-file">
        {{ file.name }}
      </span>
    </div>
  </div>
</template>

<style type="scss">
.form-filer {
  @apply inline-flex px-4 py-2 justify-center bg-gray-100 dark:bg-slate-800
  border-gray-200 dark:border-slate-700 border rounded-r;
}
</style>
