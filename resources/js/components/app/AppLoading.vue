<script setup lang="ts">
defineProps({
    size: {
        type: Number,
        required: false,
        default: 12,
    },
    spinColor: {
        type: String,
        required: false,
        default: 'blue',
    },
});
</script>

<template>
    <div :atrib="spinColor" class="relative flex aspect-square items-center justify-center p-0" :class="`w-${size} h-${size}`" v-bind="$attrs">
        <span class="absolute inset-0 aspect-square animate-spin rounded-full border-4" :class="`border-t-${spinColor}-400`"> </span>
    </div>
</template>
