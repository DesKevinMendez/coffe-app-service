<script setup>
import { buttonMenuOptions } from '@/core/sampleButtonMenuOptions';
import { mdiDotsVertical } from '@mdi/js';
import CardBox from '@/components/template/CardBox.vue';
import BaseLevel from '@/components/template/BaseLevel.vue';
import PillTag from '@/components/template/PillTag.vue';
import UserAvatar from '@/components/template/UserAvatar.vue';
import ButtonMenu from '@/components/template/ButtonMenu.vue';

defineProps({
  product: {
    type: Object,
    required: true,
    validate: (value) =>
      value.name &&
      value.date &&
      value.adjective &&
      value.material &&
      value.price,
  },
});
</script>

<template>
  <CardBox class="mb-6 last:mb-0" hoverable>
    <BaseLevel>
      <BaseLevel type="justify-start">
        <UserAvatar
          class="w-12 h-12 md:mr-6"
          api="api/bottts"
          bg=""
          :username="product.name"
        />
        <div class="text-center md:text-left">
          <h4 class="text-xl">
            {{ product.name }}
          </h4>
          <p class="text-gray-500">
            {{ product.date }}
          </p>
        </div>
      </BaseLevel>

      <BaseLevel type="justify-end">
        <div class="md:mr-6">
          <PillTag type="success" :text="product.adjective" small />
          <PillTag type="info" :text="product.material" small />
          <PillTag type="warning" :text="product.product" small />
        </div>
        <h4 class="text-xl md:mr-6">${{ product.price }}</h4>
        <ButtonMenu
          :options="buttonMenuOptions"
          :icon="mdiDotsVertical"
          small
        />
      </BaseLevel>
    </BaseLevel>
  </CardBox>
</template>
