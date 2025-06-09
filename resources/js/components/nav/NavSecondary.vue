<script setup lang="ts">
import { SidebarGroup, SidebarGroupLabel, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { useNav } from '@/composables/useNav';

const { secondary } = useNav();
</script>

<template>
    <SidebarGroup class="group-data-[collapsible=icon]:hidden" v-if="secondary.length > 0">
        <SidebarGroupLabel>Ferramentas</SidebarGroupLabel>
        <SidebarMenu>
            <SidebarMenuItem v-for="item in secondary" :key="item.title">
                <SidebarMenuButton as-child>
                    <a :href="item.href">
                        <component :is="item.icon" />
                        <span>{{ item.title }}</span>
                    </a>
                </SidebarMenuButton>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarGroup>
</template>
