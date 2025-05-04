<script setup lang="ts">
import InputError from '@/components/input/InputError.vue';
import { Button } from '@/components/ui/button';
import { Card } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { useFlashMessages } from '@/composables/useFlashMessage';
import { useAuthStore } from '@/stores/auth_store';
import { useForm } from '@inertiajs/vue3';

const flash = useFlashMessages();

const { user } = useAuthStore();
const currentData = { ...user };
const form = useForm({
    name: currentData.name,
    email: currentData.email,
});

const submit = () => {
    form.put(
        route('put.profile.data', {
            user: user.id,
        }),
        {
            preserveState: true,
            onSuccess() {
                flash.success('Dados alterados com sucesso!');
            },
            onError() {
                flash.error('Erro ao alterar dados.');
            },
        },
    );
};
</script>

<template>
    <Card class="col-span-1 grid auto-rows-min gap-6 p-4">
        <form @submit.prevent="submit" class="grid grid-cols-1 place-content-start gap-4">
            <h2 class="text-lg font-semibold">Alterar dados</h2>

            <!-- Nome -->
            <div class="grid gap-2">
                <Label for="name">Nome</Label>
                <Input id="name" type="text" required v-model="form.name" autocomplete="name" />
                <InputError v-if="form.errors.name">{{ form.errors.name }}</InputError>
            </div>

            <!-- E-mail -->
            <div class="grid gap-2">
                <Label for="email">E-mail</Label>
                <Input id="email" type="email" required v-model="form.email" autocomplete="email" />
                <InputError v-if="form.errors.email">{{ form.errors.email }}</InputError>
            </div>
            <!-- Botão de salvar -->
            <Button type="submit" :disabled="form.processing" class="mt-4">
                <LoaderCircle v-if="form.processing" class="mr-2 h-4 w-4 animate-spin" />
                Salvar dados
            </Button>
        </form>
    </Card>
</template>
