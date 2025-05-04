<script setup lang="ts">
import NavMain from '@/components/nav/NavMain.vue';
import NavSecondary from '@/components/nav/NavSecondary.vue';
import NavUser from '@/components/nav/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarProps, SidebarRail } from '@/components/ui/sidebar';
import { Link } from '@inertiajs/vue3';
import AppLogo from './AppLogo.vue';
const props = withDefaults(defineProps<SidebarProps>(), {
    collapsible: 'icon',
});
</script>
<template>
    <Sidebar v-bind="props">
        <SidebarHeader>
            <Link :href="route('get.dashboard')" class="flex justify-start">
                <AppLogo />
            </Link>
        </SidebarHeader>
        <SidebarContent>
            <NavMain />
            <NavSecondary />
        </SidebarContent>
        <SidebarFooter>
            <NavUser />
        </SidebarFooter>
        <SidebarRail />
    </Sidebar>
</template>
