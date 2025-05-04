<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import ProfileChangeOwnData from './Fragments/ProfileChangeOwnData.vue';
import ProfileChangeOwnPassword from './Fragments/ProfileChangeOwnPassword.vue';
</script>

<template>
    <Head title="Editar Perfil" />
    <h1 class="page-header">Editar Perfil</h1>
    <div class="grid grid-cols-1 place-content-start gap-4 p-4 md:grid-cols-2">
        <ProfileChangeOwnData />
        <ProfileChangeOwnPassword />
    </div>
</template>
