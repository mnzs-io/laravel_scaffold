<script setup>
import { cn } from '@/lib/utils';
import { ref } from 'vue';

const props = defineProps({
    modelValue: String,
});
const emit = defineEmits(['update:modelValue']);
const input = ref(null);

const cepMask = (e) => {
    let value = e.target.value;
    value = value.replace(/\D/g, ''); // Remove tudo que não é dígito
    value = value.replace(/^(\d{5})(\d)/, '$1-$2'); // Coloca um hífen depois dos 5 primeiros dígitos
    input.value.value = value;
    emit('update:modelValue', value.substring(0, 9)); // Garante no máximo 9 caracteres (com o hífen)
};
</script>

<template>
    <input
        ref="input"
        :value="modelValue"
        class="form-input"
        maxlength="9"
        type="tel"
        @input="cepMask"
        :class="
            cn(
                'file:text-foreground placeholder:text-muted-foreground selection:bg-primary selection:text-primary-foreground dark:bg-input/30 border-input flex h-9 w-full min-w-0 rounded-md border bg-transparent px-3 py-1 text-base shadow-xs transition-[color,box-shadow] outline-none file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm',
                'focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px]',
                'aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive',
                props.class,
            )
        "
    />
</template>
