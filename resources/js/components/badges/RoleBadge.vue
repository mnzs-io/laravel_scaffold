<script setup lang="ts">
import { Badge } from '@/components/ui/badge';
import { LaravelRole, Roles, RoleWithId } from '@/types/server/laravel';
import { computed } from 'vue';

const props = defineProps<{
    role: RoleWithId;
}>();

const roleMap = {
    [Roles.ADMIN]: {
        name: 'ADMIN',
        color: 'blue',
    },
    [Roles.CLIENT]: {
        name: 'CLIENTE',
        color: 'yellow',
    },
};

function getRoleData(role: LaravelRole) {
    return roleMap[role] ?? { name: 'Desconhecido', color: 'black' };
}

const roleObject = computed(() => {
    const roleData = getRoleData(props.role.name);
    return {
        name: roleData.name,
        color: roleData.color,
    };
});
</script>

<template>
    <Badge
        :class="`bg-${roleObject.color}-100 dark:bg-${roleObject.color}-600 text-${roleObject.color}-600 dark:text-${roleObject.color}-100 border border-${roleObject.color}-200 dark:border-${roleObject.color}-800`"
        variant="outline"
    >
        {{ roleObject.name }}
    </Badge>
</template>

<style scoped></style>
