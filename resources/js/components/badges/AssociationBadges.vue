<script setup lang="ts">
import { Association } from '@/types/server/laravel_types';
import { computed } from 'vue';
import RoleBadge from './AssociationBadge.vue';

const props = defineProps<{
    associations: Association[];
    clickable?: boolean;
    summarized?: boolean;
}>();

const emit = defineEmits(['selected']);

function select(association: Association) {
    if (props.clickable) {
        emit('selected', association);
    }
}

const summarizedAssociations = computed(() => {
    if (!props.summarized) {
        return props.associations;
    }

    const result: Association[] = [];

    for (const association of props.associations) {
        if (association.role !== 'TEACHER') {
            console.log(association);
            result.push(association);
        } else {
            const alias = 'Professor em ' + association.alias?.split('/')[1].slice(0, -1);

            if (!result.some((a) => a.alias === alias)) {
                result.push({
                    id: association.id,
                    role: 'TEACHER',
                    associable: {
                        id: association.associable?.id || '',
                        name: association.associable?.id || '',
                        slug: association.associable?.id || '',
                    },
                    alias: alias,
                });
            }
        }
    }

    return result;
});
</script>

<template>
    <div class="mx-auto flex flex-wrap items-center justify-center gap-2">
        <RoleBadge
            :class="{ 'cursor-pointer': clickable }"
            :title="association.alias || 'Desconhecido'"
            v-for="association in summarizedAssociations"
            :key="association.id + '-' + (association.alias || '')"
            :association="association"
            @click="() => select(association)"
        />
    </div>
</template>
