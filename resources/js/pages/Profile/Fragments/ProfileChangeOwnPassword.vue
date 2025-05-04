<script setup lang="ts">
import InputError from '@/components/input/InputError.vue';
import { Button } from '@/components/ui/button';
import { Card } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.put(route('put.profile.update'), {
        onFinish: () => form.reset('current_password', 'password', 'password_confirmation'),
    });
};
</script>

<template>
    <Card class="col-span-1 grid auto-rows-min gap-6 p-4">
        <h2 class="text-lg font-semibold">Alterar Senha</h2>
        <!-- Senha atual -->
        <div class="grid gap-2">
            <Label for="current_password">Senha Atual</Label>
            <Input
                id="current_password"
                type="password"
                v-model="form.current_password"
                autocomplete="current-password"
                placeholder="Deixe em branco se não for mudar"
            />
            <InputError v-if="form.errors.current_password">{{ form.errors.current_password }}</InputError>
        </div>

        <!-- Nova senha -->
        <div class="grid gap-2">
            <Label for="password">Nova Senha</Label>
            <Input id="password" type="password" v-model="form.password" autocomplete="new-password" placeholder="Nova senha" />
            <InputError v-if="form.errors.password">{{ form.errors.password }}</InputError>
        </div>

        <!-- Confirmação da nova senha -->
        <div class="grid gap-2">
            <Label for="password_confirmation">Confirmar Nova Senha</Label>
            <Input
                id="password_confirmation"
                type="password"
                v-model="form.password_confirmation"
                autocomplete="new-password"
                placeholder="Confirme a nova senha"
            />
            <InputError v-if="form.errors.password_confirmation">{{ form.errors.password_confirmation }}</InputError>
        </div>

        <!-- Botão de salvar -->
        <Button type="submit" :disabled="form.processing" class="mt-4">
            <LoaderCircle v-if="form.processing" class="mr-2 h-4 w-4 animate-spin" />
            Alterar senha
        </Button>
    </Card>
</template>
