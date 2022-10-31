<script setup>
import { computed, ref, watch } from 'vue';
import { useMainStore } from '@/stores/main.js';
import BaseLevel from '@/components/template/BaseLevel.vue';
import UserAvatar from '@/components/template/UserAvatar.vue';
import CardBox from '@/components/template/CardBox.vue';
import FormCheckRadioPicker from '@/components/template/FormCheckRadioPicker.vue';

const mainStore = useMainStore();

const userName = computed(() => mainStore.userName);

const userSwitchVal = ref([]);

watch(userSwitchVal, (value) => {
  mainStore.pushMessage(
    value && value.indexOf('one') > -1
      ? 'Success! Now active'
      : 'Done! Now inactive'
  );
});
</script>

<template>
  <CardBox class="items-center" flex-row>
    <BaseLevel type="justify-around lg:justify-center">
      <UserAvatar class="lg:mx-12" button />
      <div class="space-y-3 text-center md:text-left lg:mx-12">
        <div class="flex justify-center md:block">
          <FormCheckRadioPicker
            v-model="userSwitchVal"
            name="sample-switch"
            type="switch"
          />
        </div>
        <h1 class="text-2xl">
          Welcome back, <b>{{ userName }}</b
          >!
        </h1>
        <p>Last login <b>12 mins ago</b> from <b>127.0.0.1</b></p>
      </div>
    </BaseLevel>
  </CardBox>
</template>
