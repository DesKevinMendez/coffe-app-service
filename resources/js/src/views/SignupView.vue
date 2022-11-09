<template>
  <LayoutGuest>
    <SectionFormScreen v-slot="{ cardClass, cardRounded }" bg="signup" promo>
      <CardForm
        :class="cardClass"
        :rounded="cardRounded"
        form
        @submit="submit"
      >
        <FormField
          label="Username"
        >
          <FormControl
            v-model="form.login"
            :icon-right="mdiAccount"
            name="login"
            placeholder="johndoe"
            autocomplete="username"
          />
        </FormField>

        <FormField
          label="Email"
        >
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

        <FormField
          label="Password"
        >
          <FormControl
            v-model="form.pass"
            type="password"
            name="password"
            placeholder="Password"
            autocomplete="new-password"
          />
        </FormField>
        <template #footer>
          <BaseLevel mobile>
            <BaseButton
              label="Signup"
              type="submit"
              color="info"
            />
            <RouterLink
              to="/login"
              class="text-sm"
            >
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
import LayoutGuest from '@/layouts/LayoutGuest.vue';
import { mdiAccount, mdiEmail } from '@mdi/js';
import { reactive } from 'vue';

const form = reactive({
  login: 'johndoe',
  email: 'john.doe@example.com',
  pass: 'secret'
})

const submit = () => {
  console.log('Submit');
}
</script>