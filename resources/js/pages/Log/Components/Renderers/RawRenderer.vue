<script setup lang="ts">
import {LogRaw} from '@/types/logs'

defineProps<{log: LogRaw}>()
</script>

<template>
    <div class="p-6 space-y-4 bg-white border shadow-md rounded-xl">
        <header>
            <h1 class="text-xl font-semibold text-gray-800">Mensagem de Log</h1>
        </header>
        <div class="text-base text-gray-700">
            {{ log.detalhe.mensagem }}
        </div>
    </div>
</template>
