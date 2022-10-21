<template>
  <LayoutGuest>
    <SectionFormScreen v-slot="{ cardClass, cardRounded }" bg="login" promo>
      <CardBox
        :class="[cardClass, cardClassAddon]"
        :rounded="cardRounded"
        form
        @submit.prevent="submit"
      >
        <FormField
          label="Login"
          :error="hasError"
          help="Please enter your login"
        >
          <FormControl
            v-model="form.email"
            :error="hasError"
            :icon-right="mdiAccount"
            name="login"
            placeholder="user@example.com"
            autocomplete="username"
          />
        </FormField>

        <FormField
          label="Password"
          :error="hasError"
          help="Click icon to show/hide"
        >
          <FormControl
            v-model="form.password"
            :error="hasError"
            :tip-right="
              passShowHideClicked ? null : 'Click to show/hide'
            "
            type="password"
            name="password"
            placeholder="Password"
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
      </CardBox>
    </SectionFormScreen>
  </LayoutGuest>
</template>
<script setup lang="ts">
import { reactive, ref, computed } from "vue";
import { RouterLink } from "vue-router";
import { mdiAccount } from "@mdi/js";
import SectionFormScreen from "@/components/template/SectionFormScreen.vue";
import CardBox from "@/components/template/CardBox.vue";
import FormCheckRadioPicker from "@/components/template/FormCheckRadioPicker.vue";
import FormField from "@/components/template/FormField.vue";
import FormControl from "@/components/template/FormControl.vue";
import BaseButton from "@/components/template/BaseButton.vue";
import BaseLevel from "@/components/template/BaseLevel.vue";
import BaseButtons from "@/components/template/BaseButtons.vue";
import LayoutGuest from "@/layouts/LayoutGuest.vue";
import useRequest from "@/composables/useRequest";

const request = useRequest();

const form = reactive({
  email: "johndoe",
  password: "secret",
  remember: ["remember"],
  device_name: 'samsung'
});

const hasError = ref(false);

const cardClassAddon = computed(() => (hasError.value ? "animate-shake" : ""));

const submit = async () => {
  await request.get(
    "http://localhost:80/sanctum/csrf-cookie"
  );
  const { data } = await request.post("http://localhost:80/api/login", {
    ...form,
  });
  console.log(data.value);
  // hasError.value = true
};

const passShowHideClicked = ref(true);
</script>
