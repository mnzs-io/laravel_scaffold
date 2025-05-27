<script setup lang="ts">
import {LogRead} from '@/types/logs'

defineProps<{log: LogRead}>()
</script>

<template>
    <div class="p-6 bg-white border shadow-md rounded-xl">
        <h2 class="mb-4 text-lg font-medium text-blue-700">Perfis Acessados</h2>
        <ul class="pl-6 text-sm text-gray-700 list-disc">
            <li v-for="perfil in log.detalhe.perfis" :key="perfil">{{ perfil }}</li>
        </ul>
    </div>
</template>
