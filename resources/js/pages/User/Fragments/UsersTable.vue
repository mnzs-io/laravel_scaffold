<script setup lang="ts">
import ActiveBadge from '@/components/badges/ActiveBadge.vue';
import RoleBadgeGroup from '@/components/badges/RoleBadgeGroup.vue';
import Pagination from '@/components/table/Pagination.vue';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { getInitials } from '@/stores/auth_store';
import { User } from '@/types';
import { PaginatedResult, RoleWithId } from '@/types/server/laravel_types';
import { Link } from '@inertiajs/vue3';
import { Eye, Power } from 'lucide-vue-next';

defineProps<{
    result: PaginatedResult<User>;
}>();

const emit = defineEmits(['selected']);

function select(user: User) {
    emit('selected', user);
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
                                <th scope="col" class="text- py-3.5 pr-3 pl-4 text-sm font-semibold sm:pl-0">Usuário</th>
                                <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold">Status</th>
                                <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold">Perfil</th>
                                <th scope="col" class="px-3 py-3.5 text-end text-sm font-semibold">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            <tr v-for="user in result.data" :key="user.id">
                                <td class="py-5 pr-3 pl-4 text-sm whitespace-nowrap sm:pl-0">
                                    <div class="flex items-center">
                                        <Avatar class="h-8 w-8 rounded-lg">
                                            <AvatarImage :src="$getUserImage(user.avatar || '')" :alt="user.name" />
                                            <AvatarFallback class="rounded-lg">
                                                {{ getInitials(user.name) }}
                                            </AvatarFallback>
                                        </Avatar>
                                        <div class="ml-4">
                                            <div class="text-lg font-medium">{{ user.name }}</div>
                                            <div>{{ user.email }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-3 py-5 text-center text-sm whitespace-nowrap">
                                    <ActiveBadge :active="user.active" />
                                </td>
                                <td class="px-3 py-5 text-center text-sm whitespace-nowrap">
                                    <RoleBadgeGroup :roles="user.roles as RoleWithId[]" />
                                </td>
                                <td
                                    class="relative flex items-center justify-end space-x-2 py-5 pr-4 pl-3 text-center text-xs font-medium whitespace-nowrap sm:pr-0"
                                >
                                    <Link
                                        v-if="user.active"
                                        method="post"
                                        as="button"
                                        :href="
                                            route('post.deactivate.user', {
                                                user: user.id,
                                            })
                                        "
                                        title="Desativar usuário"
                                    >
                                        <Button variant="destructive" class="cursor-pointer"> <Power /> Desativar </Button>
                                    </Link>
                                    <Link
                                        v-else
                                        method="post"
                                        as="button"
                                        :href="
                                            route('post.activate.user', {
                                                user: user.id,
                                            })
                                        "
                                        title="Ativar usuário"
                                    >
                                        <!-- TODO: Prompt! -->
                                        <Button class="cursor-pointer bg-green-600 dark:bg-green-900 dark:text-white"> <Power /> Ativar </Button>
                                    </Link>

                                    <Button class="cursor-pointer" title="Ver detalhes" variant="outline" @click="() => select(user)">
                                        <Eye />
                                        <span class="sr-only">Ver, {{ user.name }}</span>
                                    </Button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <Pagination route="get.users.index" :result />
    </div>
</template>

<style scoped></style>
