<script setup>
import FormControl from '@/components/template/FormControl.vue';
</script>

<template>
  <FormControl
    ref="root"
    placeholder="Search (ctrl+k)"
    ctrl-k-focus
    borderless
    name="search"
  />
</template>
