<script setup lang="ts">
import { TeacherWithSubjects } from '@/types/memory_cards';
import { PaginatedResult } from '@/types/server/laravel_types';
import { ref, Ref } from 'vue';
import TeachersTable from './Fragments/TeachersTable.vue';

defineProps<{
    result: PaginatedResult<TeacherWithSubjects>;
}>();

const selectedTeacher: Ref<TeacherWithSubjects | undefined> = ref();

function select(teacher: TeacherWithSubjects) {
    selectedTeacher.value = { ...teacher };
}

function unselect() {
    selectedTeacher.value = undefined;
}
</script>

<template>
    <div class="px-4 sm:flex sm:items-center">
        <h1 class="text-base font-semibold">Professores</h1>
    </div>
    <TeachersTable :result @selected="select" />
    <!-- <TeacherForm :teacher="selectedTeacher" @saved="unselect" @canceled="unselect" /> -->
</template>
