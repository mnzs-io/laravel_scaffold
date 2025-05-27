<script setup lang="ts">
import Pagination from '@/components/table/Pagination.vue';
import { Button } from '@/components/ui/button';
import type { LogEntry } from '@/types/log_entry';
import { PaginatedResult } from '@/types/server/laravel_types';
import { format } from 'date-fns';
import { Eye } from 'lucide-vue-next';

defineProps<{
    result: PaginatedResult<LogEntry>;
}>();

const emit = defineEmits(['selected']);

function select(log: LogEntry) {
    emit('selected', log);
}

function formatDate(timestamp: number) {
    return format(new Date(timestamp * 1000), 'dd/MM/yyyy HH:mm:ss');
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
                                <th scope="col" class="px-4 py-3 text-left text-sm font-semibold">User</th>
                                <th scope="col" class="px-4 py-3 text-left text-sm font-semibold">System</th>
                                <th scope="col" class="px-4 py-3 text-left text-sm font-semibold">Type</th>
                                <th scope="col" class="px-4 py-3 text-left text-sm font-semibold">Level</th>
                                <th scope="col" class="px-4 py-3 text-left text-sm font-semibold">Timestamp</th>
                                <th scope="col" class="px-4 py-3 text-end text-sm font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            <tr v-for="log in result.data" :key="log._id">
                                <td class="px-4 py-3 text-sm whitespace-nowrap">{{ log.user }}</td>
                                <td class="px-4 py-3 text-sm whitespace-nowrap">{{ log.system }}</td>
                                <td class="px-4 py-3 text-sm whitespace-nowrap capitalize">{{ log.type }}</td>
                                <td class="px-4 py-3 text-sm whitespace-nowrap uppercase">{{ log.level }}</td>
                                <td class="px-4 py-3 text-sm whitespace-nowrap">{{ formatDate(log.timestamp) }}</td>
                                <td class="px-4 py-3 text-end whitespace-nowrap">
                                    <Button variant="outline" @click="() => select(log)">
                                        <Eye class="mr-1 h-4 w-4" />
                                        View
                                    </Button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <Pagination route="get.logs.index" :result />
    </div>
</template>

<style scoped></style>
