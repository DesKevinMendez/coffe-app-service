<script setup>
import { RouterLink } from 'vue-router';
import SectionFormScreen from '@/components/template/SectionFormScreen.vue';
import CardBox from '@/components/template/CardBox.vue';
import BaseButton from '@/components/template/BaseButton.vue';
import BaseLevel from '@/components/template/BaseLevel.vue';
import LayoutGuest from '@/layouts/LayoutGuest.vue';
</script>

<template>
  <LayoutGuest>
    <SectionFormScreen v-slot="{ cardClass, cardRounded }" bg="error">
      <CardBox :class="[cardClass, 'animate-shake']" :rounded="cardRounded">
        <div class="space-y-3">
          <h1 class="text-2xl">Unhandled exception</h1>

          <p>An Error Occurred</p>
        </div>

        <template #footer>
          <BaseLevel mobile>
            <BaseButton label="Done" to="/" color="danger" />
            <RouterLink to="/" class="text-sm"> Back home </RouterLink>
          </BaseLevel>
        </template>
      </CardBox>
    </SectionFormScreen>
  </LayoutGuest>
</template>
