<script setup lang="ts">
import {LogDelete} from '@/types/logs'

defineProps<{log: LogDelete}>()
</script>

<template>
    <div class="p-6 bg-white border shadow-md rounded-xl">
        <h2 class="mb-4 text-lg font-medium text-red-700">Registro Excluído</h2>
        <ul class="space-y-1 text-sm">
            <li v-for="(value, key) in log.detalhe.antes" :key="'delete-' + key">
                <span class="text-gray-600">{{ key }}:</span>
                <span>{{ value }}</span>
            </li>
        </ul>
    </div>
</template>
