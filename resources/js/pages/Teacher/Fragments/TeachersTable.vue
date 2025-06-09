<script setup lang="ts">
import Pagination from '@/components/table/Pagination.vue';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { TeacherWithSubjects } from '@/types/memory_cards';
import { PaginatedResult } from '@/types/server/laravel_types';
import { Eye } from 'lucide-vue-next';

defineProps<{
    result: PaginatedResult<TeacherWithSubjects>;
}>();

const emit = defineEmits<{
    (e: 'selected', teacher: TeacherWithSubjects): void;
}>();

function select(teacher: TeacherWithSubjects) {
    emit('selected', teacher);
}
</script>

<template>
    <div class="mx-auto w-full max-w-7xl sm:px-6 lg:px-8">
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <table class="min-w-full divide-y divide-zinc-300 dark:divide-zinc-800">
                        <thead>
                            <tr>
                                <th class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold sm:pl-0">Professor</th>
                                <th class="px-3 py-3.5 text-left text-sm font-semibold">Disciplinas</th>
                                <th class="px-3 py-3.5 text-end text-sm font-semibold">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            <tr v-for="teacher in result.data" :key="teacher.id">
                                <td class="py-5 pr-3 pl-4 text-sm whitespace-nowrap sm:pl-0">
                                    <div class="flex items-center space-x-3">
                                        <Avatar class="h-8 w-8 rounded-lg">
                                            <AvatarImage :src="teacher.avatar || ''" :alt="teacher.name" />
                                            <AvatarFallback class="rounded-lg bg-zinc-500 text-white">
                                                {{ teacher.name[0] }}
                                            </AvatarFallback>
                                        </Avatar>
                                        <div>
                                            <div class="text-lg font-medium">{{ teacher.name }}</div>
                                            <div class="text-muted-foreground text-xs">{{ teacher.email }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-3 py-5 text-sm whitespace-nowrap">
                                    <ul class="grid list-inside list-disc grid-cols-3 text-sm">
                                        <li v-for="subject in teacher.subjects" :key="subject.id">
                                            {{ subject.name }}
                                        </li>
                                    </ul>
                                </td>

                                <td class="flex items-center justify-end space-x-2 py-5 pr-4 pl-3 sm:pr-0">
                                    <Button variant="outline" @click="() => select(teacher)" title="Ver detalhes">
                                        <Eye />
                                        <span class="sr-only">Ver {{ teacher.name }}</span>
                                    </Button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <Pagination route="get.teachers.index" :result />
    </div>
</template>
