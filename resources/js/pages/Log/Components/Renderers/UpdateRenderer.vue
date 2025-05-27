<script setup lang="ts">
import {LogUpdate} from '@/types/logs'

const props = defineProps<{log: LogUpdate}>()

function isDifferent(key: string): boolean {
    return props.log.detalhe.antes[key] !== props.log.detalhe.depois[key]
}

function formatValue(value: any): string {
    if (value === null) return 'null'
    if (typeof value === 'boolean') return value ? 'true' : 'false'
    return String(value)
}
</script>

<template>
    <div class="p-6 space-y-4 bg-white border shadow-md rounded-xl">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div class="p-4 rounded-lg bg-red-50">
                <h2 class="mb-2 text-lg font-medium text-red-700">Antes</h2>
                <ul class="space-y-1 text-sm">
                    <li v-for="(value, key) in log.detalhe.antes" :key="'antes-' + key">
                        <span class="text-gray-600">{{ key }}:</span>
                        <span :class="{'font-bold': isDifferent(key)}">{{ formatValue(value) }}</span>
                    </li>
                </ul>
            </div>
            <div class="p-4 rounded-lg bg-green-50">
                <h2 class="mb-2 text-lg font-medium text-green-700">Depois</h2>
                <ul class="space-y-1 text-sm">
                    <li v-for="(value, key) in log.detalhe.depois" :key="'depois-' + key">
                        <span class="text-gray-600">{{ key }}:</span>
                        <span :class="{'font-bold': isDifferent(key)}">{{ formatValue(value) }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
