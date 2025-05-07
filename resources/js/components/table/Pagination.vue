<script setup lang="ts">
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { PaginateLink, PaginatedResult } from '@/types/server/laravel';
import { Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
const props = defineProps<{
    result: PaginatedResult<any>;
}>();

const perPage = ref(props.result.per_page || 10);

function resolveComponent(link: PaginateLink) {
    return link.url ? Link : 'span';
}

watch(perPage, (newValue) => {
    console.log(newValue);
    router.visit(
        route('get.users.index', {
            per_page: newValue,
        }),
    );
});
</script>

<template>
    <div
        v-if="result.links.length > 3"
        class="flex flex-col items-center justify-between gap-4 border-t border-gray-200 bg-white px-4 py-3 sm:flex-row sm:px-6"
    >
        <div class="flex items-center gap-2 text-sm text-gray-700">
            <span>Mostrando</span>
            <span class="font-medium">{{ result.from }}</span>
            <span>a</span>
            <span class="font-medium">{{ result.to }}</span>
            <span>de</span>
            <span class="font-medium">{{ result.total }}</span>
            <span>resultados</span>
        </div>

        <div class="flex items-center gap-2">
            <label for="perPage" class="text-sm text-gray-700">Itens por página:</label>
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
                        ? 'z-10 bg-indigo-600 text-white ring-indigo-600'
                        : link.url
                          ? 'text-gray-700 ring-gray-300 hover:bg-gray-50'
                          : 'cursor-default text-gray-400 ring-gray-200',
                ]"
            >
                {{ link.label }}
            </component>
        </nav>
    </div>
</template>
