<script setup lang="ts">
import { Badge } from '@/components/ui/badge';
import { computed } from 'vue';
const props = defineProps<{
    active: boolean;
}>();

const classes = computed(() => {
    return props.active
        ? 'bg-green-100 dark:bg-green-600 text-green-600 dark:text-green-100 border border-green-200 dark:border-green-800'
        : 'bg-red-100 dark:bg-red-600 text-red-600 dark:text-red-100 border border-red-200 dark:border-red-800';
});
</script>

<template>
    <Badge :class="classes" variant="outline">
        {{ active ? 'Ativo' : 'Inativo' }}
    </Badge>
</template>

<style scoped></style>
