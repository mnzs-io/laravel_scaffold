<script lang="ts">
export const description = 'A sidebar that collapses to icons.';
export const iframeHeight = '800px';
export const containerClass = 'w-full h-full';
</script>
<script setup lang="ts">
import AppBreadcrumbs from '@/components/app/AppBreadcrumbs.vue';
import AppSidebar from '@/components/app/AppSidebar.vue';
import AppThemeSelector from '@/components/app/AppThemeSelector.vue';
import { Separator } from '@/components/ui/separator';
import { SidebarInset, SidebarProvider, SidebarTrigger } from '@/components/ui/sidebar';
import { usePage } from '@inertiajs/vue3';
import LayoutWrapper from './LayoutWrapper.vue';

const page = usePage();
</script>
<template>
    <LayoutWrapper>
        <SidebarProvider>
            <AppSidebar />
            <SidebarInset>
                <header
                    class="flex h-16 shrink-0 items-center justify-between gap-2 pr-4 transition-[width,height] ease-linear group-has-[[data-collapsible=icon]]/sidebar-wrapper:h-12"
                >
                    <div class="flex items-center gap-2 px-4">
                        <SidebarTrigger class="-ml-1" />
                        <Separator orientation="vertical" class="mr-2 h-4" />
                        <AppBreadcrumbs />
                    </div>
                    <div class="flex items-center gap-2 px-4">
                        <AppThemeSelector />
                        <!-- TODO: LOGOUT -->
                    </div>
                </header>
                <slot />
            </SidebarInset>
        </SidebarProvider>
    </LayoutWrapper>
</template>
