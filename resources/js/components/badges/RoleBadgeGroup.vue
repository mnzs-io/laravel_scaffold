<script setup lang="ts">
import { RoleWithId } from '@/types/server/laravel_types';
import RoleBadge from './RoleBadge.vue';

const props = defineProps<{
    roles: RoleWithId[];
    clickable?: boolean;
}>();

const emit = defineEmits(['selected']);

function select(role: RoleWithId) {
    if (props.clickable) {
        emit('selected', role);
    }
}
</script>

<template>
    <RoleBadge :class="{ 'cursor-pointer': clickable }" v-for="role in roles" :key="role.id" :role @click="() => select(role)" />
</template>

<style scoped></style>
