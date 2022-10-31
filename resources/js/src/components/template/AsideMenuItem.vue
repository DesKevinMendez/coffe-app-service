<script setup>
import { ref, computed, watch } from 'vue';
import { RouterLink } from 'vue-router';
import { useLayoutStore } from '@/stores/layout';
import { useStyleStore } from '@/stores/style';
import { mdiMinus, mdiPlus, mdiChevronRight } from '@mdi/js';
import { getButtonColor } from '@/core/colors.js';
import BaseIcon from '@/components/template/BaseIcon.vue';
import AsideMenuList from '@/components/template/AsideMenuList.vue';

const props = defineProps({
  item: {
    type: Object,
    required: true,
  },
  isSubmenuList: Boolean,
  compact: Boolean,
});

const emit = defineEmits(['menu-click']);

const layoutStore = useLayoutStore();

const styleStore = useStyleStore();

const asideMenuItemActiveBgStyle = computed(
  () => `${styleStore.asideMenuItemActiveBgStyle} dark:bg-slate-700/25`
);

const asideMenuItemActiveStyle = computed(() =>
  hasColor.value ? '' : styleStore.asideMenuItemActiveStyle
);

const asideMenuItemInactiveStyle = computed(() =>
  hasColor.value
    ? ''
    : `${styleStore.asideMenuItemInactiveStyle} dark:text-gray-300`
);

const isAsideCompact = computed(() => layoutStore.isAsideCompact);

watch(isAsideCompact, (value) => {
  if (value) {
    isDropdownActive.value = false;
  }
});

const isDropdownActive = ref(false);

const secondaryMenu = computed(() => layoutStore.secondaryMenu);

const isSecondaryMenuActive = computed(
  () =>
    secondaryMenu.value &&
    props.item &&
    props.item.key === secondaryMenu.value.key
);

const hasColor = computed(() => props.item && props.item.color);

const componentClass = computed(() => {
  const base = [
    props.isSubmenuList ? 'py-3 px-6 text-sm' : 'py-3',
    hasColor.value
      ? getButtonColor(props.item.color, false, true)
      : `${styleStore.asideMenuItemStyle} dark:hover:bg-gray-700/50`,
  ];

  if (
    !hasColor.value &&
    (isDropdownActive.value || isSecondaryMenuActive.value)
  ) {
    base.push(asideMenuItemActiveBgStyle.value);
  }

  return base;
});

const exactActiveClass = computed(() =>
  secondaryMenu.value ? null : asideMenuItemActiveBgStyle.value
);

const componentIs = computed(() => (props.item.to ? RouterLink : 'a'));

const hasDropdown = computed(() => !!props.item.menu);

const hasSecondary = computed(() => !!props.item.menuSecondary);

const hasSub = computed(() => hasDropdown.value || hasSecondary.value);

const subIcon = computed(() => {
  if (hasSecondary.value) {
    return mdiChevronRight;
  }

  return isDropdownActive.value ? mdiMinus : mdiPlus;
});

const itemTo = computed(() => props.item.to || null);

const itemHref = computed(() => props.item.href || null);

const itemTarget = computed(() =>
  componentIs.value === 'a' && props.item.target ? props.item.target : null
);

const menuClick = (event) => {
  emit('menu-click', event, props.item);

  if (hasDropdown.value) {
    isDropdownActive.value = !isDropdownActive.value;
  }
};

const menuIconWidth = computed(() => (props.compact ? 'w-16 lg:w-20' : 'w-16'));

const updateMarkTr = computed(() => {
  const base = 'top-0 right-2';

  return props.compact ? `${base} lg:right-6` : base;
});
</script>

<template>
  <li>
    <component
      :is="componentIs"
      v-slot="vSlot"
      :to="itemTo"
      :href="itemHref"
      :target="itemTarget"
      :exact-active-class="exactActiveClass"
      class="flex cursor-pointer"
      :class="componentClass"
      @click="menuClick"
    >
      <BaseIcon
        v-if="item.icon"
        :path="item.icon"
        :update-mark="item.updateMark ?? null"
        :update-mark-tr="updateMarkTr"
        class="flex-none transition-size"
        :class="[
          vSlot && vSlot.isExactActive
            ? asideMenuItemActiveStyle
            : asideMenuItemInactiveStyle,
        ]"
        :w="menuIconWidth"
        :size="18"
      />
      <span
        class="grow animate-fade-in text-ellipsis line-clamp-1"
        :class="[
          { 'lg:hidden': compact, 'pr-12': !hasSub },
          vSlot && vSlot.isExactActive
            ? asideMenuItemActiveStyle
            : asideMenuItemInactiveStyle,
        ]"
      >{{ item.label }}</span
      >
      <BaseIcon
        v-if="hasSub"
        :path="subIcon"
        class="flex-none animate-fade-in-fast"
        :class="[
          { 'lg:hidden': compact },
          vSlot && vSlot.isExactActive
            ? asideMenuItemActiveStyle
            : asideMenuItemInactiveStyle,
        ]"
        w="w-12"
      />
    </component>
    <AsideMenuList
      v-if="hasDropdown"
      :menu="item.menu"
      :class="[
        styleStore.asideSubmenuListStyle,
        isDropdownActive ? 'block dark:bg-slate-800/50' : 'hidden',
      ]"
      is-submenu-list
    />
  </li>
</template>
