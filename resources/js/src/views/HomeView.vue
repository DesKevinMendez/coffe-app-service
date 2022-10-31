<script setup lang="ts">
import { ref, computed, watch, onMounted } from 'vue';
import { useMainStore } from '@/stores/main.js';
import { useLayoutStore } from '@/stores/layout.js';
import {
  mdiAccountMultiple,
  mdiCartOutline,
  mdiFinance,
  mdiChartPie,
  mdiReload,
} from '@mdi/js';
import * as chartConfig from '@/components/template/Charts/chart.config.js';
import LineChart from '@/components/template/Charts/LineChart.vue';
import SectionMain from '@/components/template/SectionMain.vue';
import SectionTitleLineWithButton from '@/components/template/SectionTitleLineWithButton.vue';
import CardBoxWidget from '@/components/template/CardBoxWidget.vue';
import CardBox from '@/components/template/CardBox.vue';
import CardBoxClient from '@/components/template/CardBoxClient.vue';
import CardBoxTransaction from '@/components/template/CardBoxTransaction.vue';
import CardBoxAmountItem from '@/components/template/CardBoxAmountItem.vue';

const mainStore = useMainStore();

mainStore.pushMessage('Welcome back. This is demo');

const layoutStore = useLayoutStore();

const isLg = computed(() => layoutStore.isLg);

const isMd = computed(() => layoutStore.isMd);

watch([isLg, isMd], () => {
  fillChartData();
});

const chartData = ref(null);

const fillChartData = () => {
  let points = 4;

  if (isLg.value) {
    points = 9;
  } else if (isMd.value) {
    points = 6;
  }

  chartData.value = chartConfig.sampleChartData(points);
};

onMounted(() => {
  fillChartData();
});

const userSwitchVal = ref([]);

watch(userSwitchVal, (value) => {
  mainStore.pushMessage(
    value && value.indexOf('one') > -1
      ? 'Success! Now active'
      : 'Done! Now inactive'
  );
});

const clientBarItems = computed(() => mainStore.clients.slice(0, 3));

const transactionBarItems = computed(() => mainStore.history);
</script>

<template>
  <SectionMain>
    <div class="grid grid-cols-12 gap-6 mb-6 -mx-6 md:mx-0">
      <div class="col-span-12 sm:col-span-6 xl:col-span-3">
        <CardBoxWidget
          trend="12%"
          trend-type="up"
          color="text-emerald-500"
          :icon="mdiAccountMultiple"
          :number="512"
          label="Ordenes hoy"
        />
      </div>
      <div class="col-span-12 sm:col-span-6 xl:col-span-3">
        <CardBoxWidget
          trend="12%"
          trend-type="down"
          color="text-blue-500"
          :icon="mdiCartOutline"
          :number="7770"
          prefix="$"
          label="Ventas hoy"
        />
      </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-6">
      <div class="flex flex-col">
        <CardBoxClient
          v-for="client in clientBarItems"
          :key="client.id"
          :name="client.name"
          :login="client.login"
          :date="client.created"
          :progress="client.progress"
        />
      </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-4 xl:gap-6 mb-6">
      <div class="xl:flex xl:flex-col xl:col-span-3 mb-6 xl:mb-0">
        <CardBoxTransaction
          v-for="(transaction, index) in transactionBarItems"
          :key="index"
          :amount="transaction.amount"
          :date="transaction.date"
          :business="transaction.business"
          :type="transaction.type"
          :name="transaction.name"
          :account="transaction.account"
        />
      </div>
    </div>

    <SectionTitleLineWithButton :icon="mdiChartPie" title="Trends overview" />

    <CardBox
      title="Performance"
      :icon="mdiFinance"
      :header-icon="mdiReload"
      class="mb-6"
      @header-icon-click="fillChartData"
    >
      <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
        <div v-if="chartData" class="md:col-span-3">
          <line-chart :data="chartData" />
        </div>
        <div class="text-center md:text-right">
          <CardBoxAmountItem
            title="Checking Account"
            value="$33,908.37"
            trend="12%"
            trend-type="up"
            divider
          />
          <CardBoxAmountItem
            title="Auto Loan Account"
            value="$1,456.49"
            trend="Balance low"
            trend-type="alert"
            divider
          />
          <CardBoxAmountItem
            title="Home Loan Account"
            value="$98,726.20"
            trend="24%"
            trend-type="down"
          />
        </div>
      </div>
    </CardBox>
  </SectionMain>
</template>
