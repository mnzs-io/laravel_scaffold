<script setup lang="ts">
import { Collapsible, CollapsibleContent, CollapsibleTrigger } from '@/components/ui/collapsible';
import {
    SidebarGroup,
    SidebarGroupLabel,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    SidebarMenuSub,
    SidebarMenuSubButton,
    SidebarMenuSubItem,
} from '@/components/ui/sidebar';
import { useNav } from '@/composables/useNav';
import { useAuthStore } from '@/stores/auth_store';
import { Link, usePage } from '@inertiajs/vue3';
import { ChevronRight } from 'lucide-vue-next';

const { main, shouldShow } = useNav();
const page = usePage();
const { user } = useAuthStore();
</script>

<template>
    <SidebarGroup>
        <SidebarGroupLabel>Menu</SidebarGroupLabel>
        <SidebarMenu>
            <Collapsible v-for="item in main" :key="item.slug" as-child :default-open="page.url.startsWith(item.slug)" class="group/collapsible">
                <SidebarMenuItem v-if="shouldShow(user, item.roles)">
                    <CollapsibleTrigger as-child>
                        <SidebarMenuButton :tooltip="item.title">
                            <component :is="item.icon" v-if="item.icon" />
                            <span>{{ item.title }} {{ item.isActive }}</span>
                            <ChevronRight class="ml-auto transition-transform duration-200 group-data-[state=open]/collapsible:rotate-90" />
                        </SidebarMenuButton>
                    </CollapsibleTrigger>
                    <CollapsibleContent>
                        <SidebarMenuSub>
                            <SidebarMenuSubItem v-for="subItem in item.items" :key="subItem.title">
                                <SidebarMenuSubButton as-child>
                                    <Link :href="subItem.href">
                                        <span>{{ subItem.title }}</span>
                                    </Link>
                                </SidebarMenuSubButton>
                            </SidebarMenuSubItem>
                        </SidebarMenuSub>
                    </CollapsibleContent>
                </SidebarMenuItem>
            </Collapsible>
        </SidebarMenu>
    </SidebarGroup>
</template>
