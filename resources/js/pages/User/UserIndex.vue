<script setup lang="ts">
import { User } from '@/types';
import { PaginatedResult } from '@/types/server/laravel_types';
import { ref, Ref } from 'vue';
import UserForm from './Fragments/UserForm.vue';
import UsersTable from './Fragments/UsersTable.vue';

defineProps<{
    result: PaginatedResult<User>;
}>();

const selectedUser: Ref<User | undefined> = ref();

function select(user: User) {
    selectedUser.value = { ...user };
}

function unselect() {
    selectedUser.value = undefined;
}
</script>

<template>
    <div class="px-4 sm:flex sm:items-center">
        <h1 class="text-base font-semibold">Usuários</h1>
    </div>
    <UsersTable :result @selected="select" />
    <UserForm :user="selectedUser" @saved="unselect" @canceled="unselect" />
</template>

<style scoped></style>
