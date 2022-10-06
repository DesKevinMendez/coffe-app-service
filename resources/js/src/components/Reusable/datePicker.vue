<template>
  <Datepicker v-model="date" :format="format" input-class-name="dp-custom-input"/>
</template>

<script setup>
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import { ref } from "vue";

const date = ref(null);
const format = (date) => {
  const day = date.getDate();
  const month = date.getMonth() + 1;
  const year = date.getFullYear();

  return `${year}/${month}/${day}`;
};
</script>

<style lang="scss">
.dp-custom-input {
  @apply relative border-gray-700 py-3 dark:bg-slate-800 border-t
    border-b rounded border-l border-r dark:text-gray-400
}
</style>
