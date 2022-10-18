<script setup>
import { computed } from "vue";
import BaseLevel from "@/components/template/BaseLevel.vue";
import KevinLogo from "@/components/template/KevinLogo.vue";

const year = computed(() => new Date().getFullYear());
</script>

<template>
    <footer
        class="bg-gray-50 py-2 px-6 dark:bg-slate-900/70 bottom-0 lg:absolute left-0 w-full"
    >
        <BaseLevel class="md:px-6 xl:max-w-7xl xl:mx-auto">
            <div>&copy; {{ year }}, Kevin Méndez</div>
            <div class="md:py-2">
                <a href="https://justboil.me">
                    <KevinLogo class="w-auto h-8 md:h-6" />
                </a>
            </div>
        </BaseLevel>
    </footer>
</template>
