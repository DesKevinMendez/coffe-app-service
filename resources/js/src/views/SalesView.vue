<template>
  <LayoutAuthenticated>
    <SectionMain>
      <SectionTitleLineWithButton
        :icon="mdiStoreClock"
        title="Ventas"
        main
      >
        <FormControl
          v-model="search"
          :icon-left="mdiStoreSearch"
          placeholder="Buscar"
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
            >
            </BaseButton>
          </div>
          <section>
            <div class="grid grid-cols-12 gap-6">
              <div class="col-span-4">
                <FormField label="Mesero" vertical>
                  <FormControl
                    placeholder="Nombre"
                  />
                </FormField>
              </div>
              <div class="col-span-4">
                <FormField label="Orden" vertical>
                  <FormControl
                    type="number"
                    placeholder="Número de orden"
                  />
                </FormField>
              </div>
              <div class="col-span-4">
                <FormField
                  label="Fecha"
                  vertical
                >
                  <DatePicker></DatePicker>
                </FormField>
              </div>
            </div>
          </section>
        </template>
        <CoffeTable :fields="columns" :items="orders" />
      </CardBox>
    </SectionMain>
  </LayoutAuthenticated>
</template>
<script setup lang="ts">
import { useMainStore } from "@/stores/main.js";
import { mdiCoffeeMaker, mdiStoreClock, mdiStoreSearch, mdiFilter } from "@mdi/js";
import SectionMain from "@/components/template/SectionMain.vue";
import CardBox from "@/components/template/CardBox.vue";
import CoffeTable from "@/components/Reusable/CoffeTable.vue";
import LayoutAuthenticated from "@/layouts/LayoutAuthenticated.vue";
import TableSampleClients from "@/components/template/TableSampleClients.vue";
import SectionTitleLineWithButton from "@/components/template/SectionTitleLineWithButton.vue";
import BaseButton from "@/components/template/BaseButton.vue";
import { ref } from "vue";
import FormField from "@/components/template/FormField.vue";
import FormControl from "@/components/template/FormControl.vue";
import DatePicker from "@/components/Reusable/datePicker.vue";

const mainStore = useMainStore();
const search = ref("");
mainStore.pushMessage("Welcome back. This is demo");
const columns = [
  {
    label: "Mesero/a",
    key: "user",
  },
  {
    label: "Orden",
    key: "orderCount",
  },
  {
    label: "Total orden",
    key: "total",
  },
  {
    label: "Hora",
    key: "created_at",
  },
];
const orders = [
  {
    id: 1,
    orderCount: 20,
    user: "Kevin Méndez",
    total: "$5.99",
    created_at: "16:59",
  },
  {
    id: 2,
    orderCount: 19,
    user: "Kevin Méndez",
    total: "$10.99",
    created_at: "16:59",
  },
];
</script>
