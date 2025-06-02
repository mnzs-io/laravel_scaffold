<script setup lang="ts">
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';

const model = defineModel<'raw' | 'beforeAfter' | 'remove' | 'insert' | 'event' | 'read'>();

const TYPES = [
    { value: 'raw', label: 'Raw' },
    { value: 'beforeAfter', label: 'Before/After' },
    { value: 'remove', label: 'Remove' },
    { value: 'insert', label: 'Insert' },
    { value: 'event', label: 'Event' },
    { value: 'read', label: 'Read' },
];
</script>

<template>
    <div class="flex flex-col items-start justify-end space-y-2">
        <Label>Tipo</Label>
        <Select v-model="model" label="Type" placeholder="Selecione um tipo">
            <SelectTrigger class="w-[180px]">
                <SelectValue placeholder="Selecione um tipo" />
            </SelectTrigger>
            <SelectContent>
                <SelectGroup>
                    <SelectItem v-for="item in TYPES" :key="item.value" :value="item.value">
                        {{ item.label }}
                    </SelectItem>
                </SelectGroup>
            </SelectContent>
        </Select>
    </div>
</template>

<style scoped></style>
