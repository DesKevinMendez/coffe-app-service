<template>
  <LayoutGuest>
    <SectionFormScreen v-slot="{ cardClass, cardRounded }" bg="login" promo>
      <CardForm
        :class="[cardClass, cardClassAddon]"
        :rounded="cardRounded"
        form
        @submit="submit"
      >
        <FormField label="Login" :error="hasError">
          <FormControl
            v-model="form.email"
            :error="hasError"
            :icon-right="mdiAccount"
            name="login"
            rules="required|email"
            placeholder="user@example.com"
            autocomplete="username"
          />
        </FormField>

        <FormField label="Password" :error="hasError">
          <FormControl
            v-model="form.password"
            :error="hasError"
            :tip-right="
              passShowHideClicked ? null : 'Click to show/hide'
            "
            type="password"
            name="password"
            placeholder="Password"
            rules="required"
            autocomplete="current-password"
            @right-icon-click="passShowHideClicked = true"
          />
        </FormField>

        <BaseLevel mobile>
          <FormCheckRadioPicker
            v-model="form.remember"
            name="remember"
            :options="{ remember: 'Remember' }"
            spaced
          />
          <RouterLink to="/remind" class="text-sm">
            Forgot password?
          </RouterLink>
        </BaseLevel>

        <template #footer>
          <BaseLevel mobile>
            <BaseButtons>
              <BaseButton
                label="Login"
                type="submit"
                color="info"
              />
            </BaseButtons>
          </BaseLevel>
        </template>
      </CardForm>
    </SectionFormScreen>
  </LayoutGuest>
</template>
<script setup lang="ts">
import { reactive, ref, computed } from "vue";
import { RouterLink, useRouter } from "vue-router";
import { mdiAccount } from "@mdi/js";
import SectionFormScreen from "@/components/template/SectionFormScreen.vue";
import CardForm from "@/components/template/CardForm.vue";
import FormCheckRadioPicker from "@/components/template/FormCheckRadioPicker.vue";
import FormField from "@/components/template/FormField.vue";
import FormControl from "@/components/template/FormControl.vue";
import BaseButton from "@/components/template/BaseButton.vue";
import BaseLevel from "@/components/template/BaseLevel.vue";
import BaseButtons from "@/components/template/BaseButtons.vue";
import LayoutGuest from "@/layouts/LayoutGuest.vue";
import useRequest from "@/composables/useRequest";
import { useAuth } from "@/stores/auth";

const request = useRequest();

const form = reactive({
  email: "kevin@coffeapp.com",
  password: "password",
  remember: ["remember"],
  device_name: "samsung",
});

const hasError = ref(false);

const cardClassAddon = computed(() => (hasError.value ? "animate-shake" : ""));

const uRou = useRouter();
const auth = useAuth();

const submit = async () => {
  await request.get("sanctum/csrf-cookie");
  const { data } = await request.post<{ token: string }>("api/login", {
    ...form,
  });

  auth.setLogin(data.value.token);
  uRou.push({ name: "home" });
};

const passShowHideClicked = ref(true);
</script>
