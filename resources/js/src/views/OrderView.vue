<template>
    <LayoutAuthenticated>
        <SectionMain>
            <SectionTitleLineWithButton
                :icon="mdiStoreClock"
                title="Ordenes"
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
            >
                <CoffeTable :fields="columns" :items="orders" />
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>
<script setup lang="ts">
import { useMainStore } from "@/stores/main.js";
import { mdiCoffeeMaker, mdiStoreClock, mdiStoreSearch } from "@mdi/js";
import SectionMain from "@/components/template/SectionMain.vue";
import CardBox from "@/components/template/CardBox.vue";
import CoffeTable from "@/components/Reusable/CoffeTable.vue";
import LayoutAuthenticated from "@/layouts/LayoutAuthenticated.vue";
import TableSampleClients from "@/components/template/TableSampleClients.vue";
import SectionTitleLineWithButton from "@/components/template/SectionTitleLineWithButton.vue";
import BaseButton from "@/components/template/BaseButton.vue";
import { ref } from "vue";
import FormControl from "@/components/template/FormControl.vue";

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
