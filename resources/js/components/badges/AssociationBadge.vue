<script setup lang="ts">
import { Badge } from '@/components/ui/badge';
import { Association, LaravelRole, Role } from '@/types/server/laravel_types';

const props = defineProps<{
    association: Association;
}>();

function getColor(role: LaravelRole): string {
    switch (role) {
        case Role.ADMIN:
            return 'blue';
        case Role.CLIENT:
            return 'yellow';
        case Role.SUPER_ADMIN:
            return 'red';
        case Role.TEACHER:
            return 'green';
        case Role.STUDENT:
            return 'purple';
        default:
            return 'gray';
    }
}

const color = getColor(props.association.role);
</script>

<template>
    <Badge
        :class="`bg-${color}-100 dark:bg-${color}-600 text-${color}-600 dark:text-${color}-100 border border-${color}-200 dark:border-${color}-800 text-xs`"
        variant="outline"
    >
        {{ props.association.alias }}
    </Badge>
</template>
