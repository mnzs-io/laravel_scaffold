<script setup lang="ts">
import { Organization } from '@/types/memory_cards';
import { PaginatedResult } from '@/types/server/laravel_types';
import { ref, Ref } from 'vue';
import OrganizationForm from './Fragments/OrganizationForm.vue';
import OrganizationsTable from './Fragments/OrganizationTable.vue';

defineProps<{
    result: PaginatedResult<Organization>;
}>();

const selectedOrganization: Ref<Organization | undefined> = ref();

function select(org: Organization) {
    selectedOrganization.value = { ...org };
}

function unselect() {
    selectedOrganization.value = undefined;
}
</script>

<template>
    <div class="px-4 sm:flex sm:items-center">
        <h1 class="text-base font-semibold">Organizações</h1>
    </div>
    <OrganizationsTable :result @selected="select" />
    <OrganizationForm :organization="selectedOrganization" @saved="unselect" @canceled="unselect" />
</template>
