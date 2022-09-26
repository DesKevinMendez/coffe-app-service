<script setup lang="ts">
import { reactive } from "vue";

interface tUser {
    name: string;
}

const user = reactive<tUser>({
    name: "Kevin Méndez",
});
</script>

<template>
    <h1 class="text-3xl font-bold underline">{{ user.name }}</h1>
</template>
