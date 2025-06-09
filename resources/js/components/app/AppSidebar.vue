<script setup lang="ts">
import NavList from '@/components/nav/NavList.vue';
import NavSecondary from '@/components/nav/NavSecondary.vue';
import NavUser from '@/components/nav/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarProps, SidebarRail } from '@/components/ui/sidebar';
import { useNav } from '@/composables/useNav';
import { Link } from '@inertiajs/vue3';
import AppLogo from './AppLogo.vue';
const props = withDefaults(defineProps<SidebarProps>(), {
    collapsible: 'icon',
});

const { teacherMenu, studentMenu, adminMenu, superAdminMenu } = useNav();
</script>
<template>
    <Sidebar v-bind="props">
        <SidebarHeader>
            <Link :href="route('get.dashboard')" class="flex justify-start">
                <AppLogo />
            </Link>
        </SidebarHeader>
        <SidebarContent class="flex flex-col justify-start">
            <NavList :menu="superAdminMenu" label="Menu Super Admin" role="SUPER_ADMIN" />
            <NavList :menu="adminMenu" label="Menu Administrador" role="ADMIN" />
            <NavList :menu="teacherMenu" label="Menu Professor" role="TEACHER" />
            <NavList :menu="studentMenu" label="Menu Aluno" role="STUDENT" />
        </SidebarContent>
        <NavSecondary />
        <SidebarFooter>
            <NavUser />
        </SidebarFooter>
        <SidebarRail />
    </Sidebar>
</template>
