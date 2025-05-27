<script setup lang="ts">
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { PaginateLink, PaginatedResult } from '@/types/server/laravel_types';
import { Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
const props = defineProps<{
    result: PaginatedResult<any>;
    route: string;
}>();

const perPage = ref(props.result.per_page || 10);

function resolveComponent(link: PaginateLink) {
    return link.url ? Link : 'span';
}

watch(perPage, (newValue) => {
    console.log(newValue);
    router.visit(
        route(props.route, {
            per_page: newValue,
        }),
    );
});

function label(link: PaginateLink): string {
    if (link.label.includes('Previous')) return 'Anterior';
    if (link.label.includes('Next')) return 'Próximo';
    return link.label.replace(/&laquo;|&raquo;/g, '').trim(); // se quiser remover os « »
}
</script>
<template>
    <div
        v-if="result.links.length > 3"
        class="flex flex-col items-center justify-between gap-4 border-t border-zinc-100 bg-white px-4 py-3 sm:flex-row sm:px-6 dark:border-zinc-800 dark:bg-zinc-900"
    >
        <div class="flex items-center gap-2 text-sm text-zinc-700 dark:text-zinc-300">
            <span>Mostrando</span>
            <span class="font-medium">{{ result.from }}</span>
            <span>a</span>
            <span class="font-medium">{{ result.to }}</span>
            <span>de</span>
            <span class="font-medium">{{ result.total }}</span>
            <span>resultados</span>
        </div>

        <div class="flex items-center gap-2">
            <label for="perPage" class="text-sm text-zinc-700 dark:text-zinc-300">Itens por página:</label>
            <Select v-model="perPage">
                <SelectTrigger>
                    <SelectValue :placeholder="perPage.toString()" />
                </SelectTrigger>
                <SelectContent>
                    <SelectGroup>
                        <SelectItem value="6"> 6 </SelectItem>
                        <SelectItem value="12"> 12 </SelectItem>
                        <SelectItem value="20"> 20 </SelectItem>
                    </SelectGroup>
                </SelectContent>
            </Select>
        </div>

        <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
            <component
                :is="resolveComponent(link)"
                v-for="(link, index) in result.links"
                :key="index"
                :href="link.url"
                :only="['result']"
                preserve-scroll
                class="relative inline-flex items-center px-4 py-2 text-sm font-medium ring-1 ring-inset"
                :class="[
                    link.active
                        ? 'z-10 bg-yellow-600 text-white ring-yellow-600'
                        : link.url
                          ? 'text-zinc-700 ring-zinc-300 hover:bg-zinc-50 dark:text-zinc-200 dark:ring-zinc-600 dark:hover:bg-zinc-800'
                          : 'cursor-default text-zinc-400 ring-zinc-200 dark:text-zinc-500 dark:ring-zinc-700',
                ]"
            >
                {{ label(link) }}
            </component>
        </nav>
    </div>
</template>
