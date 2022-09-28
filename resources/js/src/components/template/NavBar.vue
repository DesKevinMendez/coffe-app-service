<script setup>
import { computed, ref } from "vue";
import { useMainStore } from "@/stores/main.js";
import { useLayoutStore } from "@/stores/layout.js";
import { useStyleStore } from "@/stores/style.js";
import {
    mdiForwardburger,
    mdiBackburger,
    mdiClose,
    mdiDotsVertical,
    mdiAccount,
    mdiCogOutline,
    mdiEmail,
    mdiLogout,
    mdiBell,
    mdiThemeLightDark,
} from "@mdi/js";
import NavBarItemLabel from "@/components/template/NavBarItemLabel.vue";
import NavBarMenu from "@/components/template/NavBarMenu.vue";
import BaseDivider from "@/components/template/BaseDivider.vue";
import UserAvatar from "@/components/template/UserAvatar.vue";
import BaseIcon from "@/components/template/BaseIcon.vue";
import NavBarSearch from "@/components/template/NavBarSearch.vue";
import NavBarItem from "@/components/template/NavBarItem.vue";

const layoutStore = useLayoutStore();

const isAsideRightActive = computed(() => layoutStore.isAsideRightActive);

const isAsideMobileExpanded = computed(() => layoutStore.isAsideMobileExpanded);

const menuToggleMobileIcon = computed(() =>
    isAsideMobileExpanded.value ? mdiBackburger : mdiForwardburger
);

const menuToggleMobile = () => layoutStore.asideMobileToggle();

const asideRightToggle = () => {
    updatesClicked.value = true;
    layoutStore.asideRightToggle();
};

const isMenuNavBarActive = ref(false);

const menuNavBarToggleIcon = computed(() =>
    isMenuNavBarActive.value ? mdiClose : mdiDotsVertical
);

const menuNavBarToggle = () => {
    isMenuNavBarActive.value = !isMenuNavBarActive.value;
};

const updatesClicked = ref(false);

const mainStore = useMainStore();

const updatesUpdateMark = computed(() =>
    !updatesClicked.value && mainStore.updatesStatus ? "warning" : null
);

const toggleLightDark = () => {
    useStyleStore().setDarkMode();
};
</script>

<template>
    <nav
        class="lg:pl-22 fixed top-0 inset-x-0 bg-gray-50 dark:bg-slate-800 h-14 z-30 w-screen transition-position lg:transition-none lg:w-auto"
    >
        <div class="lg:px-6 xl:max-w-7xl xl:mx-auto flex lg:items-stretch">
            <div class="flex-1 items-stretch flex h-14">
                <NavBarItem
                    type="flex lg:hidden"
                    @click.prevent="menuToggleMobile"
                >
                    <BaseIcon :path="menuToggleMobileIcon" size="24" />
                </NavBarItem>
                <NavBarItem type="hidden lg:flex" class="xl:-ml-3">
                    <NavBarSearch />
                </NavBarItem>
            </div>
            <div class="flex-none items-stretch flex h-14 lg:hidden">
                <NavBarItem
                    :active="isAsideRightActive"
                    @click="asideRightToggle"
                >
                    <BaseIcon
                        :path="mdiBell"
                        :update-mark="updatesUpdateMark"
                        size="20"
                    />
                </NavBarItem>
                <NavBarItem @click.prevent="menuNavBarToggle">
                    <BaseIcon :path="menuNavBarToggleIcon" size="20" />
                </NavBarItem>
            </div>
            <div
                class="absolute w-screen top-14 left-0 bg-gray-50 shadow lg:w-auto lg:items-stretch lg:flex lg:grow lg:static lg:border-b-0 lg:overflow-visible lg:shadow-none dark:bg-slate-800"
                :class="{
                    hidden: !isMenuNavBarActive,
                    block: isMenuNavBarActive,
                }"
            >
                <div
                    class="max-h-screen-menu overflow-y-auto lg:overflow-visible lg:flex lg:items-stretch lg:justify-end lg:ml-auto"
                >
                    <NavBarMenu>
                        <UserAvatar class="w-6 h-6 mr-3 inline-flex" />
                        <div>
                            <span>{{ mainStore.userName }}</span>
                        </div>

                        <template #dropdown>
                            <NavBarItem to="/profile">
                                <NavBarItemLabel
                                    :icon="mdiAccount"
                                    label="My Profile"
                                />
                            </NavBarItem>
                            <NavBarItem>
                                <NavBarItemLabel
                                    :icon="mdiCogOutline"
                                    label="Settings"
                                />
                            </NavBarItem>
                            <NavBarItem>
                                <NavBarItemLabel
                                    :icon="mdiEmail"
                                    label="Messages"
                                />
                            </NavBarItem>
                            <BaseDivider nav-bar />
                            <NavBarItem to="/login">
                                <NavBarItemLabel
                                    :icon="mdiLogout"
                                    label="Log Out"
                                />
                            </NavBarItem>
                        </template>
                    </NavBarMenu>
                    <NavBarItem
                        is-desktop-icon-only
                        @click.prevent="toggleLightDark"
                    >
                        <NavBarItemLabel
                            :icon="mdiThemeLightDark"
                            label="Light/Dark"
                            is-desktop-icon-only
                        />
                    </NavBarItem>
                </div>
            </div>
        </div>
    </nav>
</template>
