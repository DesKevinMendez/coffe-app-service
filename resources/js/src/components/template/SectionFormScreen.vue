<script setup>
import { computed } from 'vue';
import { useRoute, RouterLink } from 'vue-router';
import { useStyleStore } from '@/stores/style.js';
import {
  sectionBgLogin,
  sectionBgLoginDark,
  sectionBgError,
  sectionBgErrorDark,
} from '@/core/colors';
import KevinLogo from '@/components/template/KevinLogo.vue';
import BaseButtons from '@/components/template/BaseButtons.vue';
import BaseButton from '@/components/template/BaseButton.vue';

const props = defineProps({
  bg: {
    type: String,
    required: true,
    validator: (value) =>
      ['login', 'signup', 'remind', 'error'].includes(value),
  },
  promo: Boolean,
});

const darkMode = computed(() => useStyleStore().darkMode);

const colorClass = computed(() => {
  switch (props.bg) {
  case 'login':
    return darkMode.value ? sectionBgLoginDark : sectionBgLogin;
  case 'error':
    return darkMode.value ? sectionBgErrorDark : sectionBgError;
  }

  return '';
});

const route = useRoute();

const currentRouteName = route.name;

const routes = {
  login: 'Login',
  error: 'Error',
};
</script>

<template>
  <section class="section-screen-content transition-background-image" :class="colorClass">
    <div v-if="promo" class="space-y-12 px-12">
      <div class="hidden lg:block">
        <BaseButtons type="justify-center" glue>
          <BaseButton
            v-for="(routeLabel, index) in routes"
            :key="index"
            rounded-full
            :to="{ name: index }"
            :active-soft="index === currentRouteName"
            :label="routeLabel"
            :outline="darkMode"
            no-focus-ring
            addon
          />
        </BaseButtons>
      </div>

      <div class="text-center text-white py-12 md:py-0">
        <h1 class="text-5xl lg:text-6xl font-black">All instances</h1>
        <h2 class="text-2xl">managed from one place</h2>
      </div>
      <div
        class="hidden md:block py-12 md:py-0 text-center text-white text-opacity-50 dark:text-opacity-80"
      >
        <RouterLink to="/"> Instagram </RouterLink> |
        <RouterLink to="/"> Telegram </RouterLink> |
        <RouterLink to="/"> Teletype </RouterLink>
      </div>
      <div class="hidden md:block text-white">
        <RouterLink to="/">
          <KevinLogo class="w-auto h-12 mx-auto" />
        </RouterLink>
      </div>
    </div>

    <slot
      card-class="w-11/12 md:w-7/12 lg:w-5/12 xl:w-4/12 shadow-2xl"
      card-rounded="rounded-lg"
    />

    <div v-if="promo" class="md:hidden space-y-12 py-12">
      <div class="text-white text-opacity-50">
        <RouterLink to="/"> Instagram </RouterLink> |
        <RouterLink to="/"> Telegram </RouterLink> |
        <RouterLink to="/"> Teletype </RouterLink>
      </div>
      <div class="text-white">
        <RouterLink to="/">
          <KevinLogo class="w-auto h-8 mx-auto" />
        </RouterLink>
      </div>
    </div>
  </section>
</template>

<style lang="scss">
.section-screen-content {
  @apply flex flex-col items-center md:flex-row md:justify-around
  md:px-6 min-h-screen duration-1000;
}
</style>
