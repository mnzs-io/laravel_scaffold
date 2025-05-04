<script setup lang="ts">
import { Breadcrumb, BreadcrumbItem, BreadcrumbLink, BreadcrumbList, BreadcrumbSeparator } from '@/components/ui/breadcrumb';
import { SharedData } from '@/types';
import { usePage } from '@inertiajs/vue3';
const page = usePage<SharedData>();
</script>

<template>
    <Breadcrumb>
        <BreadcrumbList>
            <template v-for="(breadcrumb, index) in page.props.breadcrumbs" :key="breadcrumb.href || '#'">
                <BreadcrumbItem class="hidden md:block">
                    <BreadcrumbLink href="#">{{ breadcrumb.title }}</BreadcrumbLink>
                </BreadcrumbItem>
                <BreadcrumbSeparator class="hidden md:block" v-if="index < page.props.breadcrumbs.length - 1" />
            </template>
        </BreadcrumbList>
    </Breadcrumb>
</template>

<style scoped></style>
