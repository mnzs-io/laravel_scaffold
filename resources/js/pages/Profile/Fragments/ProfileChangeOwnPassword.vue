<script setup lang="ts">
import InputError from '@/components/input/InputError.vue';
import { Button } from '@/components/ui/button';
import { Card } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { useFlashMessages } from '@/composables/useFlashMessage';
import { useAuthStore } from '@/stores/auth_store';
import { useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

const { user } = useAuthStore();
const flash = useFlashMessages();

const form = useForm({
    current: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.put(
        route('put.profile.password', {
            user: user.id,
        }),
        {
            preserveState: true,
            onSuccess() {
                flash.success('Dados alterados com sucesso!');
                form.reset();
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
            <h2 class="text-lg font-semibold">Alterar Senha</h2>
            <!-- Senha atual -->
            <div class="grid gap-2">
                <Label for="current">Senha Atual</Label>
                <Input
                    id="current"
                    type="password"
                    v-model="form.current"
                    autocomplete="current-password"
                    placeholder="Deixe em branco se não for mudar"
                />
                <InputError v-if="form.errors.current">{{ form.errors.current }}</InputError>
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
        </form>
    </Card>
</template>
