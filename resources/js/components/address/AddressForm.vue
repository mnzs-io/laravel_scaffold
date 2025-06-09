<script setup lang="ts">
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Address } from '@/types/memory_cards';
import { reactive, watch } from 'vue';
import CepInput from '../input/CepInput.vue';
import SelectUf from '../input/SelectUf.vue';

const model = defineModel<Address>();
const emit = defineEmits<{
    (e: 'updated', value: Address): void;
}>();

// Criar um state local para editar sem modificar o model diretamente
const local = reactive<Address>({
    street: '',
    number: '',
    complement: '',
    neighborhood: '',
    city: '',
    state: '',
    postal_code: '',
    country: '',
});

// Quando o model for alterado externamente, atualize o local
watch(
    () => model.value,
    (val) => {
        if (val) Object.assign(local, val);
    },
    { immediate: true, deep: true },
);

// Sempre que local mudar, emitir 'updated'
watch(
    () => ({ ...local }),
    (val) => {
        emit('updated', val);
    },
    { deep: true },
);
</script>

<template>
    <div class="col-span-full grid grid-cols-4 gap-2">
        <div class="col-span-3">
            <Label class="mb-1" for="street">Rua</Label>
            <Input id="street" v-model="local.street" type="text" />
        </div>

        <div class="col-span-1">
            <Label class="mb-1" for="number">Número</Label>
            <Input id="number" v-model="local.number" type="text" />
        </div>

        <div class="col-span-2">
            <Label class="mb-1" for="complement">Complemento</Label>
            <Input id="complement" v-model="local.complement" type="text" />
        </div>

        <div class="col-span-2">
            <Label class="mb-1" for="neighborhood">Bairro</Label>
            <Input id="neighborhood" v-model="local.neighborhood" type="text" />
        </div>

        <div class="col-span-2">
            <Label class="mb-1" for="city">Cidade</Label>
            <Input id="city" v-model="local.city" type="text" />
        </div>

        <div class="col-span-1">
            <Label class="mb-1" for="state">Estado</Label>
            <SelectUf v-model="local.state" />
        </div>

        <div class="col-span-2">
            <Label class="mb-1" for="postal_code">CEP</Label>
            <CepInput v-model="local.postal_code" />
        </div>

        <div class="col-span-2">
            <Label class="mb-1" for="country">País</Label>
            <Input id="country" v-model="local.country" type="text" />
        </div>
    </div>
</template>
