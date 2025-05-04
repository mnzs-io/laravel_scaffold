<script setup lang="ts">
import { User } from '@/types';

defineProps<{
    users: User[];
}>();
</script>

<template>
    <pre>
        {{ users }}
    </pre>
</template>

<style scoped></style>
