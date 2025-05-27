<script setup lang="ts">
import { RoleWithId } from '@/types/server/laravel_types';

defineProps<{
    options: RoleWithId[];
    modelValue: RoleWithId[];
}>();

const emit = defineEmits(['update:modelValue']);

function toggleRole(e) {
    console.log('change>: ' + e);
}
</script>

<template>
    <RoleBadge
        class="cursor-pointer opacity-50 transition-all"
        :class="{ 'opacity-100': modelValue.some((r) => r.id === role.id) }"
        v-for="role in options"
        :key="role.id"
        :role
        @click="() => toggleRole(role)"
    />
</template>

<style scoped></style>
