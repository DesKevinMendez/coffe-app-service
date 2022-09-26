<script setup>
import { ref, reactive } from 'vue'
import { useMainStore } from '@/stores/main.js'
import { mdiAccount, mdiAccountCircle, mdiLock, mdiMail, mdiFormTextboxPassword, mdiLifebuoy } from '@mdi/js'
import { buttonMenuOptions } from '@/core/sampleButtonMenuOptions.js'
import SectionMain from '@/components/SectionMain.vue'
import CardBox from '@/components/CardBox.vue'
import BaseDivider from '@/components/BaseDivider.vue'
import FormField from '@/components/FormField.vue'
import FormControl from '@/components/FormControl.vue'
import UserCard from '@/components/UserCard.vue'
import BaseButtons from '@/components/BaseButtons.vue'
import BaseButton from '@/components/BaseButton.vue'
import BaseLevel from '@/components/BaseLevel.vue'
import ButtonTextLink from '@/components/ButtonTextLink.vue'
import ButtonMenu from '@/components/ButtonMenu.vue'
import SectionBottomOtherPages from '@/components/SectionBottomOtherPages.vue'
import SectionTitleLineWithButton from '@/components/SectionTitleLineWithButton.vue'
import LayoutAuthenticated from '@/layouts/LayoutAuthenticated.vue'

const mainStore = useMainStore()

const profileForm = reactive({
  name: mainStore.userName,
  email: mainStore.userEmail
})

const passShowHideClicked = ref(false)

const passwordForm = reactive({
  password_current: 'my-secret-password',
  password: '',
  password_confirmation: ''
})

const submitProfile = () => {
  mainStore.setUser(profileForm)
  mainStore.pushMessage('Updated. Demo only')
}

const submitPass = () => {
  mainStore.pushMessage('Updated. Demo only')
}
</script>

<template>
  <LayoutAuthenticated>
    <SectionMain>
      <SectionTitleLineWithButton
        :icon="mdiAccount"
        title="Profile"
        main
      >
        <BaseButton
          href="https://justboil.me/tailwind-admin-templates/vue-dashboard/"
          label="Buy dashboard"
          color="contrast"
          rounded-full
          small
        />
      </SectionTitleLineWithButton>
      <UserCard class="mb-6" />
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <CardBox
          title="Edit Profile"
          :icon="mdiAccountCircle"
          form
          @submit.prevent="submitProfile"
        >
          <FormField
            label="Name"
            help="Required. Your name"
          >
            <FormControl
              v-model="profileForm.name"
              :icon-left="mdiAccount"
              name="name"
              autocomplete="name"
              required
            />
          </FormField>
          <FormField
            label="E-mail"
            help="Required. Your e-mail"
          >
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
                <BaseButton
                  type="submit"
                  label="Update"
                  color="info"
                />
                <ButtonMenu
                  :options="buttonMenuOptions"
                  label="Options"
                  color="info"
                  outline
                  left
                />
              </BaseButtons>
              <ButtonTextLink
                label="Need help?"
                :icon="mdiLifebuoy"
              />
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
            <BaseButton
              type="submit"
              label="Change"
              color="info"
            />
          </template>
        </CardBox>
      </div>
    </SectionMain>
    <SectionBottomOtherPages />
  </LayoutAuthenticated>
</template>
