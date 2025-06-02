<script setup lang="ts">
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';

// Define os possíveis valores do model
const model = defineModel<'emergency' | 'alert' | 'critical' | 'error' | 'warning' | 'notice' | 'info' | 'debug'>();

const LEVELS = [
    { label: 'Emergency', value: 'emergency' },
    { label: 'Alert', value: 'alert' },
    { label: 'Critical', value: 'critical' },
    { label: 'Error', value: 'error' },
    { label: 'Warning', value: 'warning' },
    { label: 'Notice', value: 'notice' },
    { label: 'Info', value: 'info' },
    { label: 'Debug', value: 'debug' },
];
</script>

<template>
    <div class="flex flex-col items-start justify-end space-y-2">
        <Label>Nível</Label>
        <Select v-model="model" label="Nível" placeholder="Selecione um tipo" all-options>
            <SelectTrigger class="w-[180px]">
                <SelectValue placeholder="Selecione um nível" />
            </SelectTrigger>
            <SelectContent>
                <SelectGroup>
                    <SelectItem v-for="level in LEVELS" :key="level.value" :value="level.value">
                        {{ level.label }}
                    </SelectItem>
                </SelectGroup>
            </SelectContent>
        </Select>
    </div>
</template>

<style scoped></style>
