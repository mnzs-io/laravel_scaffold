<script setup lang="ts">
import { Badge } from '@/components/ui/badge';
import { useAuthStore } from '@/stores/auth_store';
import { LaravelRole, Roles } from '@/types/server/laravel';
import { computed } from 'vue';

const roleMap = {
    [Roles.ADMIN]: {
        name: 'ADMIN',
        color: 'red',
    },
    [Roles.GUEST]: {
        name: 'CONVIDADO',
        color: 'gray',
    },
};

function getRoleData(role: LaravelRole) {
    return roleMap[role] ?? { name: 'Desconhecido', color: 'black' };
}

const { role } = useAuthStore();

const roleObject = computed(() => {
    const roleData = getRoleData(role);
    return {
        name: roleData.name,
        color: roleData.color,
    };
});
</script>

<template>
    <Badge :class="`bg-${roleObject.color}-600 text-${roleObject.color}-100`" variant="outline">{{ roleObject.name }}</Badge>
</template>

<style scoped></style>
