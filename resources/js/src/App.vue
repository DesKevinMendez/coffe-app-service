<script setup>
import { RouterView } from 'vue-router';
import { useMainStore } from '@/stores/main.js';

const mainStore = useMainStore();
const avatar =
  'https://avatars.dicebear.com/api/avataaars/example.svg?options[top][]=shortHair&options[accessoriesChance]=93';
mainStore.setUser({
  name: 'Kevin Méndez',
  email: 'kevin@coffeapp.com',
  avatar,
});
</script>

<template>
  <RouterView />
</template>
