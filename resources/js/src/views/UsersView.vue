<template>
  <LayoutAuthenticated>
    <SectionMain>
      <SectionTitleLineWithButton
        :icon="mdiAccountMultiple"
        title="Usuarios"
        main
      >
        <FormControl
          v-model="search"
          :icon-left="mdiAccountSearch"
          placeholder="Buscar"
        />
      </SectionTitleLineWithButton>
      <CardBox
        :icon="mdiAccountMultiple"
        title="Usuarios activos"
        has-table
        header
        smaller-padding
      >
        <template #header>
          <div class="flex justify-end">
            <BaseButton
              label="Nuevo usuario"
              type="button"
              color="info"
              @click="newUser"
            >
            </BaseButton>
          </div>
        </template>
        <CoffeTable :fields="columns" :items="orders" />
      </CardBox>
      <NewUser v-model="showNewUserModal" />
    </SectionMain>
  </LayoutAuthenticated>
</template>
<script setup lang="ts">
import { useMainStore } from "@/stores/main.js";
import { mdiAccountMultiple, mdiAccountSearch } from "@mdi/js";
import SectionMain from "@/components/template/SectionMain.vue";
import CardBox from "@/components/template/CardBox.vue";
import CoffeTable from "@/components/Reusable/CoffeTable.vue";
import LayoutAuthenticated from "@/layouts/LayoutAuthenticated.vue";
import TableSampleClients from "@/components/template/TableSampleClients.vue";
import SectionTitleLineWithButton from "@/components/template/SectionTitleLineWithButton.vue";
import { ref } from "vue";
import FormControl from "@/components/template/FormControl.vue";
import BaseButton from "@/components/template/BaseButton.vue";
import NewUser from "@/components/users/newUser.vue";

const mainStore = useMainStore();
const search = ref("");
mainStore.pushMessage("Welcome back. This is demo");
const showNewUserModal = ref(false);

const newUser = () => {
  showNewUserModal.value = true;
};

const columns = [
  {
    label: "Nombre",
    key: "name",
  },
  {
    label: "Correo electrónico",
    key: "email",
  },
  {
    label: "Rol",
    key: "role",
  },
  {
    label: "Fecha de registro",
    key: "created_at",
  },
];
const orders = [
  {
    id: 1,
    email: "kevin@mail.io",
    name: "Kevin Méndez",
    role: "Admin",
    created_at: "16:59",
  },
  {
    id: 2,
    email: "kevin@mail.io",
    name: "Kevin Méndez",
    role: "Admin",
    created_at: "16:59",
  },
];
</script>
