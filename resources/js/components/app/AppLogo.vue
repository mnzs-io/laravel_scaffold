<script setup lang="ts">
import AppLogoIcon from '@/components/app/AppLogoIcon.vue';
import { SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { useAppStore } from '@/stores/app_store';
const app = useAppStore();
</script>

<template>
    <SidebarMenu>
        <SidebarMenuItem>
            <SidebarMenuButton size="lg" class="data-[state=open]:bg-sidebar-accent data-[state=open]:text-sidebar-accent-foreground cursor-pointer">
                <div class="bg-sidebar-primary text-sidebar-primary-foreground flex aspect-square size-8 items-center justify-center rounded-lg">
                    <AppLogoIcon />
                </div>
                <div class="grid flex-1 text-left text-sm leading-tight">
                    <span class="truncate font-semibold"> {{ app.name }} </span>
                </div>
            </SidebarMenuButton>
        </SidebarMenuItem>
    </SidebarMenu>
</template>
