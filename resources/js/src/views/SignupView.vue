<template>
  <LayoutGuest>
    <SectionFormScreen v-slot="{ cardClass, cardRounded }" bg="signup" promo>
      <CardForm :class="cardClass" :rounded="cardRounded" form @submit="submit">
        <FormField label="Username">
          <FormControl
            v-model="form.name"
            :icon-right="mdiAccount"
            name="name"
            placeholder="johndoe"
            autocomplete="username"
          />
        </FormField>

        <FormField label="Email">
          <FormControl
            v-model="form.email"
            :icon-right="mdiEmail"
            name="email"
            type="email"
            placeholder="user@example.com"
            rules="required|email"
            autocomplete="false"
          />
        </FormField>

        <FormField label="Password">
          <FormControl
            v-model="form.password"
            type="password"
            name="password"
            placeholder="Password"
            rules="required|passwordStrong"
            autocomplete="new-password"
          />
        </FormField>
        <FormField label="Password confirmation">
          <FormControl
            v-model="form.password_confirmation"
            type="password"
            name="password_confirmation"
            placeholder="Password"
            rules="confirmed:@password"
            autocomplete="new-password"
          />
        </FormField>
        <template #footer>
          <BaseLevel mobile>
            <BaseButton label="Signup" type="submit" color="info" />
            <RouterLink to="/login" class="text-sm">
              Have an account?
            </RouterLink>
          </BaseLevel>
        </template>
      </CardForm>
    </SectionFormScreen>
  </LayoutGuest>
</template>

<script setup lang="ts">
import BaseButton from '@/components/template/BaseButton.vue';
import BaseLevel from '@/components/template/BaseLevel.vue';
import CardForm from '@/components/template/CardForm.vue';
import FormControl from '@/components/template/FormControl.vue';
import FormField from '@/components/template/FormField.vue';
import SectionFormScreen from '@/components/template/SectionFormScreen.vue';
import useRequest from '@/composables/useRequest';
import LayoutGuest from '@/layouts/LayoutGuest.vue';
import { useAuth } from '@/stores/auth';
import { mdiAccount, mdiEmail } from '@mdi/js';
import { reactive } from 'vue';
import { useRouter } from 'vue-router';

const request = useRequest();

const form = reactive({
  name: 'johndoe',
  email: 'john.doe@example.com',
  password: 'Hola123!',
  password_confirmation: 'Hola123!',
  device_name: Math.random(),
});

const uRou = useRouter();
const auth = useAuth();

const submit = async () => {
  await request.get('sanctum/csrf-cookie');
  const { data, statusCode } = await request.post<{ token: string }>(
    'api/register',
    {
      ...form,
    }
  );

  if (statusCode.value == 422) {
    return;
  }

  auth.setLogin(data.value.token);
  uRou.push({ name: 'home' });
};
</script>
