<template>
  <SectionMain>
    <SectionTitleLineWithButton :icon="mdiStoreClock" title="Productos" main>
      <FormControl
        v-model="search"
        :icon-left="mdiStoreSearch"
        placeholder="Buscar"
        name="buscar"
      />
    </SectionTitleLineWithButton>
    <CardBox
      :icon="mdiCoffeeMaker"
      title="Listado del día de hoy"
      has-table
      header
      smaller-padding
    >
      <template #header>
        <div class="flex justify-end">
          <BaseButton
            type="button"
            color="info"
            :icon="mdiFilter"
            @click="showFilter"
          >
          </BaseButton>
        </div>
        <Collapse>
          <section v-show="filter">
            <div class="grid grid-cols-12 gap-6">
              <div class="col-span-4">
                <FormField label="Tipo" vertical>
                  <FormControl
                    v-model="filters.type"
                    type="list"
                    :options="listBoxOptions"
                    name="tipo"
                  />
                </FormField>
              </div>
            </div>
          </section>
        </Collapse>
      </template>
      <CoffeTable :fields="columns" :items="orders" />
    </CardBox>
  </SectionMain>
</template>
<script setup lang="ts">
import { useMainStore } from '@/stores/main';
import {
  mdiCoffeeMaker,
  mdiStoreClock,
  mdiStoreSearch,
  mdiFilter,
} from '@mdi/js';
import SectionMain from '@/components/template/SectionMain.vue';
import CardBox from '@/components/template/CardBox.vue';
import CoffeTable from '@/components/Reusable/CoffeTable.vue';
import SectionTitleLineWithButton from '@/components/template/SectionTitleLineWithButton.vue';
import BaseButton from '@/components/template/BaseButton.vue';
import { ref } from 'vue';
import FormField from '@/components/template/FormField.vue';
import FormControl from '@/components/template/FormControl.vue';
import Collapse from '@/components/Reusable/Collapse.vue';

const mainStore = useMainStore();
const search = ref('');
const filter = ref(false);
const filters = ref({ type: '' });
mainStore.pushMessage('Welcome back. This is demo');

const listBoxOptions = [
  { id: 1, label: 'Permanentes', unavailable: false },
  { id: 2, label: 'Por día', unavailable: false },
];

const showFilter = () => {
  filter.value = !filter.value;
};
const columns = [
  {
    label: 'Producto',
    key: 'user',
  },
  {
    label: 'Precio',
    key: 'orderCount',
  },
  {
    label: 'Tipo',
    key: 'created_at',
  },
];
const orders = [
  {
    id: 1,
    orderCount: 20,
    user: 'Kevin Méndez',
    total: '$5.99',
    created_at: '16:59',
  },
  {
    id: 2,
    orderCount: 19,
    user: 'Kevin Méndez',
    total: '$10.99',
    created_at: '16:59',
  },
];
</script>
