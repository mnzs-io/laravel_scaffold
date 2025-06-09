<script setup lang="ts">
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';

const props = defineProps<{
    modelValue?: string;
}>();

const emit = defineEmits<{
    (e: 'update:modelValue', value: string): void;
}>();

const ufs = [
    'AC',
    'AL',
    'AP',
    'AM',
    'BA',
    'CE',
    'DF',
    'ES',
    'GO',
    'MA',
    'MT',
    'MS',
    'MG',
    'PA',
    'PB',
    'PR',
    'PE',
    'PI',
    'RJ',
    'RN',
    'RS',
    'RO',
    'RR',
    'SC',
    'SP',
    'SE',
    'TO',
];
</script>

<template>
    <Select :model-value="props.modelValue" @update:model-value="emit('update:modelValue', $event)">
        <SelectTrigger class="w-full">
            <SelectValue placeholder="Selecione a UF" />
        </SelectTrigger>
        <SelectContent>
            <SelectItem v-for="uf in ufs" :key="uf" :value="uf">
                {{ uf }}
            </SelectItem>
        </SelectContent>
    </Select>
</template>
