<template>
  <div>
    <CardBoxModal
      v-model="showModal"
      title="Agregar nuevo usuario"
      button-label="Agregar"
      :text-link-icon="mdiLifebuoy"
      has-cancel
    >
      <FormField label="Nombre" vertical>
        <FormControl
          v-model="user.name"
          :icon-left="mdiAccount"
          placeholder="Nombre completo"
          name="nombre"
        />
      </FormField>
      <FormField label="Correo" vertical>
        <FormControl
          v-model="user.email"
          :icon-left="mdiEmail"
          type="email"
          name="email"
          placeholder="Email"
        />
      </FormField>
      <FormField label="Rol" vertical>
        <FormControl
          v-model="user.role"
          type="list"
          name="rol"
          :options="listBoxOptions"
        />
      </FormField>
    </CardBoxModal>
  </div>
</template>

<script setup lang="ts">
import CardBoxModal from '@/components/template/CardBoxModal.vue';
import { computed, reactive } from 'vue-demi';
import FormControl from '@/components/template/FormControl.vue';
import FormField from '../template/FormField.vue';
import { mdiEmail, mdiAccount, mdiLifebuoy } from '@mdi/js';

const emit = defineEmits(['update:modelValue']);

const props = defineProps({
  modelValue: { required: true, type: Boolean },
});

const user = reactive({
  name: '',
  email: '',
  role: '',
});

const listBoxOptions = [
  { id: 1, label: 'Administrador', unavailable: false },
  { id: 2, label: 'Mesero', unavailable: false },
  { id: 3, label: 'Bartender', unavailable: false },
];

const showModal = computed({
  get: () => props.modelValue,
  set: (value) => emit('update:modelValue', value),
});
</script>

<style lang="scss" scoped></style>
