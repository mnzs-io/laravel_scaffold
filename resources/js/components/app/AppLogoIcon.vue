<script setup lang="ts">
import { useAppStore } from '@/stores/app_store';
const { logo, name } = useAppStore();
</script>

<template>
    <img class="h-9 w-9" :src="logo" :alt="name" :title="name" v-bind="$attrs" />
</template>
