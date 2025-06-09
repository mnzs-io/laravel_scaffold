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
import { Link, usePage } from '@inertiajs/vue3';
import { ChevronRight } from 'lucide-vue-next';

const { shouldShow } = useNav();
const page = usePage();

defineProps<{
    isOpen: boolean;
    role: LaravelRole;
    label: string;
    menu: NavGroup[];
}>();
</script>

<template>
    <SidebarGroup v-if="shouldShow(role)">
        <SidebarGroupLabel>{{ label }}</SidebarGroupLabel>
        <SidebarMenu>
            <Collapsible v-for="item in menu" :key="item.slug" as-child :default-open="page.url.startsWith(item.slug)" class="group/collapsible">
                <SidebarMenuItem v-if="shouldShow(item.roles)">
                    <CollapsibleTrigger as-child>
                        <SidebarMenuButton :tooltip="item.title" v-if="item.items">
                            <component :is="item.icon" v-if="item.icon" />
                            <span>{{ item.title }} {{ item.isActive }}</span>
                            <ChevronRight
                                v-if="item.items"
                                class="ml-auto transition-transform duration-200 group-data-[state=open]/collapsible:rotate-90"
                            />
                        </SidebarMenuButton>
                        <Link :href="item.href" v-if="item.href" class="cursor-pointer" :class="{ active: $page.url === item.url }">
                            <SidebarMenuButton class="cursor-pointer">
                                <component :is="item.icon" v-if="item.icon" />
                                <span>{{ item.title }} {{ item.isActive }}</span>
                            </SidebarMenuButton>
                        </Link>
                    </CollapsibleTrigger>
                    <CollapsibleContent v-if="item.items">
                        <SidebarMenuSub>
                            <SidebarMenuSubItem v-for="subItem in item.items" :key="subItem.title">
                                <SidebarMenuSubButton as-child>
                                    <Link :href="subItem.href" :class="{ active: $page.url === subItem.url }">
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
