<template>
  <table>
    <thead>
      <tr class="tr-head">
        <th v-for="field in displayedFields" :key="field.key">
          <slot :name="`head(${field.key})`" :field="field">
            {{ field.label }}
          </slot>
        </th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="item in items" :key="item.id">
        <Component
          :is="cellElement(key)"
          v-for="(key, $index) in displayedFieldKeys"
          :key="$index"
          :data-label="dataLabel[$index]"
        >
          <slot
            :name="`row(${key})`"
            :value="format(item, key)"
            :item="item"
            :format="(k) => format(item, k)"
          >
            {{ format(item, key) }}
          </slot>
        </Component>
      </tr>
    </tbody>
  </table>
</template>

<script lang="ts" setup>
import { computed, PropType } from 'vue';

interface TableField {
  key: string;
  label: string;
  format?: (item: unknown) => string;
  hidden?: boolean;
  header?: boolean;
}

interface TableItem {
  id: number | string;
  [key: string]: unknown;
}

const props = defineProps({
  fields: { type: Array as PropType<TableField[]>, default: () => [] },
  items: { type: Array as PropType<TableItem[]>, default: () => [] },
});

const displayedFields = computed(() => props.fields.filter((i) => !i.hidden));

const displayedFieldKeys = computed(() => {
  return Object.entries(displayedFields.value).map(
    // eslint-disable-next-line @typescript-eslint/no-unused-vars
    ([_key, value]) => value.key
  );
});

const cellElement = (key: string) => {
  const field = props.fields.find((f) => f.key === key);
  return field && field.header ? 'th' : 'td';
};

const format = (item: TableItem, key: string) => {
  const field = props.fields.find((f) => f.key === key);
  return field && field.format ? field.format(item[key]) : item[key];
};

const dataLabel = computed(() => props.fields.map((f) => f.label));
</script>
