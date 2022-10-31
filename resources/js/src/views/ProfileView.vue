<script setup>
import { ref, reactive } from 'vue';
import { useMainStore } from '@/stores/main';
import {
  mdiAccount,
  mdiAccountCircle,
  mdiLock,
  mdiMail,
  mdiFormTextboxPassword,
  mdiLifebuoy,
} from '@mdi/js';
import { buttonMenuOptions } from '@/core/sampleButtonMenuOptions';
import SectionMain from '@/components/template/SectionMain.vue';
import CardBox from '@/components/template/CardBox.vue';
import BaseDivider from '@/components/template/BaseDivider.vue';
import FormField from '@/components/template/FormField.vue';
import FormControl from '@/components/template/FormControl.vue';
import UserCard from '@/components/template/UserCard.vue';
import BaseButtons from '@/components/template/BaseButtons.vue';
import BaseButton from '@/components/template/BaseButton.vue';
import BaseLevel from '@/components/template/BaseLevel.vue';
import ButtonTextLink from '@/components/template/ButtonTextLink.vue';
import ButtonMenu from '@/components/template/ButtonMenu.vue';
import SectionBottomOtherPages from '@/components/template/SectionBottomOtherPages.vue';

const mainStore = useMainStore();

const profileForm = reactive({
  name: mainStore.userName,
  email: mainStore.userEmail,
});

const passShowHideClicked = ref(false);

const passwordForm = reactive({
  password_current: 'my-secret-password',
  password: '',
  password_confirmation: '',
});

const submitProfile = () => {
  mainStore.setUser(profileForm);
  mainStore.pushMessage('Updated. Demo only');
};

const submitPass = () => {
  mainStore.pushMessage('Updated. Demo only');
};
</script>

<template>
  <SectionMain>
    <UserCard class="mb-6" />
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <CardBox
        title="Edit Profile"
        :icon="mdiAccountCircle"
        form
        @submit.prevent="submitProfile"
      >
        <FormField label="Name" help="Required. Your name">
          <FormControl
            v-model="profileForm.name"
            :icon-left="mdiAccount"
            name="name"
            autocomplete="name"
            required
          />
        </FormField>
        <FormField label="E-mail" help="Required. Your e-mail">
          <FormControl
            v-model="profileForm.email"
            :icon-left="mdiMail"
            name="email"
            type="email"
            autocomplete="email"
            required
          />
        </FormField>

        <template #footer>
          <BaseLevel>
            <BaseButtons>
              <BaseButton type="submit" label="Update" color="info" />
              <ButtonMenu
                :options="buttonMenuOptions"
                label="Options"
                color="info"
                outline
                left
              />
            </BaseButtons>
            <ButtonTextLink label="Need help?" :icon="mdiLifebuoy" />
          </BaseLevel>
        </template>
      </CardBox>
      <CardBox
        title="Change Password"
        :icon="mdiLock"
        form
        @submit.prevent="submitPass"
      >
        <FormField
          label="Current password"
          help="Required. Your current password"
        >
          <FormControl
            v-model="passwordForm.password_current"
            name="password_current"
            type="password"
            required
            autcomplete="current-password"
            :tip-right="passShowHideClicked ? null : 'Click to show/hide'"
            @right-icon-click="passShowHideClicked = true"
          />
        </FormField>

        <BaseDivider />

        <FormField label="New password">
          <FormControl
            v-model="passwordForm.password"
            name="password"
            type="password"
            required
            autcomplete="new-password"
            :icon-left="mdiFormTextboxPassword"
            help="Required. New password"
            placeholder="New password"
          />
          <FormControl
            v-model="passwordForm.password_confirmation"
            name="password_confirmation"
            type="password"
            required
            autcomplete="new-password"
            :icon-left="mdiFormTextboxPassword"
            help="Required. New password one more time"
            placeholder="Confirm"
          />
        </FormField>
        <template #footer>
          <BaseButton type="submit" label="Change" color="info" />
        </template>
      </CardBox>
    </div>
  </SectionMain>
  <SectionBottomOtherPages />
</template>
