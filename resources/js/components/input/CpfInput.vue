<script setup>
import { ref } from 'vue';

const props = defineProps({
    modelValue: String,
});
const emit = defineEmits(['update:modelValue']);
const input = ref(null);
const cpfMask = (e) => {
    let value = e.target.value;
    value = value.replace(/\D/g, ''); //Removaluee tudo o que não é dígito
    value = value.replace(/(\d{3})(\d)/, '$1.$2'); //Coloca um ponto entre o terceiro e o quarto dígitos
    value = value.replace(/(\d{3})(\d)/, '$1.$2'); //Coloca um ponto entre o terceiro e o quarto dígitos
    value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2'); //Coloca um hífen entre o terceiro e o quarto dígitos
    input.value.value = value;
    emit('update:modelValue', value.substring(0, 14));
};
</script>

<template>
    <input ref="input" :value="modelValue" class="form-input" maxlength="14" type="tel" @input="(e) => cpfMask(e)" />
</template>
