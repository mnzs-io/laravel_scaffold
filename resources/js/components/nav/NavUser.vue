<script setup lang="ts">
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuGroup,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { SidebarMenu, SidebarMenuButton, SidebarMenuItem, useSidebar } from '@/components/ui/sidebar';
import { useNav } from '@/composables/useNav';
import { useAuthStore } from '@/stores/auth_store';
import { Link } from '@inertiajs/vue3';
import { LogOut } from 'lucide-vue-next';
import { storeToRefs } from 'pinia';

const { isMobile } = useSidebar();

const { name, email, avatar, initials } = storeToRefs(useAuthStore());

const { user: userNav } = useNav();
</script>

<template>
    <SidebarMenu>
        <SidebarMenuItem>
            <DropdownMenu>
                <DropdownMenuTrigger as-child>
                    <SidebarMenuButton size="lg" class="data-[state=open]:bg-sidebar-accent data-[state=open]:text-sidebar-accent-foreground">
                        <Avatar class="h-8 w-8 rounded-lg">
                            <AvatarImage :src="avatar" :alt="name" />
                            <AvatarFallback class="rounded-lg">
                                {{ initials }}
                            </AvatarFallback>
                        </Avatar>
                        <div class="grid flex-1 text-left text-sm leading-tight">
                            <span class="truncate font-semibold">{{ name }}</span>
                            <span class="truncate text-xs">{{ email }}</span>
                        </div>
                        <ChevronsUpDown class="ml-auto size-4" />
                    </SidebarMenuButton>
                </DropdownMenuTrigger>
                <DropdownMenuContent
                    class="w-[--reka-dropdown-menu-trigger-width] min-w-56 rounded-lg"
                    :side="isMobile ? 'bottom' : 'right'"
                    align="end"
                    :side-offset="4"
                >
                    <DropdownMenuLabel class="p-0 font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                            <Avatar class="h-8 w-8 rounded-lg">
                                <AvatarImage :src="avatar" :alt="name" />
                                <AvatarFallback class="rounded-lg"> {{ initials }} </AvatarFallback>
                            </Avatar>
                            <div class="grid flex-1 text-left text-sm leading-tight">
                                <span class="truncate font-semibold">{{ name }}</span>
                            </div>
                        </div>
                    </DropdownMenuLabel>
                    <DropdownMenuSeparator />

                    <DropdownMenuGroup>
                        <Link :href="item.href" v-for="item in userNav" :key="item.href">
                            <DropdownMenuItem class="cursor-pointer">
                                <component :is="item.icon" />
                                {{ item.title }}
                            </DropdownMenuItem>
                        </Link>
                    </DropdownMenuGroup>
                    <DropdownMenuSeparator />
                    <Link method="post" :href="route('post.auth.logout')">
                        <DropdownMenuItem class="cursor-pointer">
                            <LogOut />
                            Sair
                        </DropdownMenuItem>
                    </Link>
                </DropdownMenuContent>
            </DropdownMenu>
        </SidebarMenuItem>
    </SidebarMenu>
</template>
