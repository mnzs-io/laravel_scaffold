<script setup lang="ts">
import AppToaster from '@/components/app/AppToaster.vue';
import { useFlashMessages } from '@/composables/useFlashMessage';

const flashmessages = useFlashMessages();
flashmessages.registerListener();
</script>
<template>
    <slot />
    <AppToaster />
</template>
