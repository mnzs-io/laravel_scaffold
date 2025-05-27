<script setup lang="ts">
import AuthSimpleLayout from '@/layouts/auth/AuthSimpleLayout.vue';
import LayoutWrapper from './LayoutWrapper.vue';
</script>

<template>
    <LayoutWrapper>
        <AuthSimpleLayout>
            <slot />
        </AuthSimpleLayout>
    </LayoutWrapper>
</template>
