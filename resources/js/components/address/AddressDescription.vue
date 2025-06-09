<script setup lang="ts">
import { Address } from '@/types/memory_cards';

defineProps<{
    address: Address;
}>();
</script>

<template>
    <div class="flex flex-wrap">
        <span>{{ address.street }}, {{ address.number || 'S/N' }} </span>
        <span v-if="address.neighborhood"> - {{ address.neighborhood }}</span>
        <span v-if="address.city">, {{ address.city }}/{{ address.state }}</span>
        <span v-if="address.postal_code">, CEP {{ address.postal_code }}</span>
    </div>
</template>

<style scoped></style>
