<script setup lang="ts">
import ActiveBadge from '@/components/badges/ActiveBadge.vue';
import Pagination from '@/components/table/Pagination.vue';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { Organization } from '@/types';
import { PaginatedResult } from '@/types/server/laravel_types';
import { Eye } from 'lucide-vue-next';

defineProps<{
    result: PaginatedResult<Organization>;
}>();

const emit = defineEmits(['selected']);

function select(org: Organization) {
    emit('selected', org);
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
                                <th class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold sm:pl-0">Organização</th>
                                <th class="px-3 py-3.5 text-left text-sm font-semibold">Plano</th>
                                <th class="px-3 py-3.5 text-center text-sm font-semibold">Status</th>
                                <th class="px-3 py-3.5 text-end text-sm font-semibold">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            <tr v-for="org in result.data" :key="org.id">
                                <td class="py-5 pr-3 pl-4 text-sm whitespace-nowrap sm:pl-0">
                                    <div class="flex items-center space-x-3">
                                        <Avatar class="h-8 w-8 rounded-lg">
                                            <AvatarImage :src="org.logo_url || ''" :alt="org.name" />
                                            <AvatarFallback class="rounded-lg text-white" :style="{ backgroundColor: org.color ?? '#ccc' }">
                                                {{ org.name[0] }}
                                            </AvatarFallback>
                                        </Avatar>
                                        <div>
                                            <div class="text-lg font-medium">{{ org.name }}</div>
                                            <div class="text-muted-foreground text-xs">{{ org.slug }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-3 py-5 text-sm whitespace-nowrap">PLANO BÁSICO</td>

                                <td class="px-3 py-5 text-center">
                                    <ActiveBadge :active="org.active" />
                                </td>

                                <td class="flex items-center justify-end space-x-2 py-5 pr-4 pl-3 sm:pr-0">
                                    <!-- <Link v-if="org.active" method="post" as="button" :href="route('post.deactivate.organization', { id: org.id })">
                                        <Button variant="destructive" title="Desativar"><Power /> Desativar</Button>
                                    </Link>
                                    <Link v-else method="post" as="button" :href="route('post.activate.organization', { id: org.id })">
                                        <Button class="bg-green-600 dark:bg-green-900 dark:text-white" title="Ativar"><Power /> Ativar</Button>
                                    </Link> -->

                                    <Button variant="outline" @click="() => select(org)" title="Ver detalhes">
                                        <Eye />
                                        <span class="sr-only">Ver {{ org.name }}</span>
                                    </Button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <Pagination route="get.organizations.index" :result />
    </div>
</template>
