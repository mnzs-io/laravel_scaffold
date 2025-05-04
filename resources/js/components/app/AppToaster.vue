<script setup lang="ts">
import { Bug, CheckCircle2, Info, LoaderIcon, TriangleAlert } from 'lucide-vue-next';
import { Toaster } from 'vue-sonner';
</script>

<template>
    <Toaster>
        <template #loading-icon>
            <LoaderIcon />
        </template>
        <template #success-icon>
            <CheckCircle2 />
        </template>
        <template #error-icon>
            <Bug />
        </template>
        <template #info-icon>
            <Info />
        </template>
        <template #warning-icon>
            <TriangleAlert />
        </template>
    </Toaster>
</template>

<style scoped></style>
