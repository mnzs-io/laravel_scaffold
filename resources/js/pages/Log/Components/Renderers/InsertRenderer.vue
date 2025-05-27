<script setup lang="ts">
import {LogInsert} from '@/types/logs'

defineProps<{log: LogInsert}>()
</script>

<template>
    <div class="p-6 bg-white border shadow-md rounded-xl">
        <h2 class="mb-4 text-lg font-medium text-green-700">Registro Inserido</h2>
        <ul class="space-y-1 text-sm">
            <li v-for="(value, key) in log.detalhe.depois" :key="'insert-' + key">
                <span class="text-gray-600">{{ key }}:</span>
                <span>{{ value }}</span>
            </li>
        </ul>
    </div>
</template>
