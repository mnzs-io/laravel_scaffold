<script lang="ts">
export default {
    layout: AuthLayout,
};
</script>

<script setup lang="ts">
import InputError from '@/components/input/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('post.auth.register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Criar Conta" />

    <form @submit.prevent="submit" class="flex flex-col gap-6">
        <div class="grid gap-6">
            <div class="grid gap-2">
                <Label for="name">Nome</Label>
                <Input
                    id="name"
                    type="text"
                    required
                    autofocus
                    :tabindex="1"
                    autocomplete="name"
                    v-model="form.name"
                    placeholder="Seu nome completo"
                />
                <InputError v-if="form.errors.name">
                    {{ form.errors.name }}
                </InputError>
            </div>

            <div class="grid gap-2">
                <Label for="email">E-mail</Label>
                <Input id="email" type="email" required :tabindex="2" autocomplete="email" v-model="form.email" placeholder="email@example.com" />
                <InputError v-if="form.errors.email">
                    {{ form.errors.email }}
                </InputError>
            </div>

            <div class="grid gap-2">
                <Label for="password">Senha</Label>
                <Input id="password" type="password" required :tabindex="3" autocomplete="new-password" v-model="form.password" placeholder="Senha" />
                <InputError v-if="form.errors.password">
                    {{ form.errors.password }}
                </InputError>
            </div>

            <div class="grid gap-2">
                <Label for="password_confirmation">Confirmar Senha</Label>
                <Input
                    id="password_confirmation"
                    type="password"
                    required
                    :tabindex="4"
                    autocomplete="new-password"
                    v-model="form.password_confirmation"
                    placeholder="Repita a senha"
                />
                <InputError v-if="form.errors.password_confirmation">
                    {{ form.errors.password_confirmation }}
                </InputError>
            </div>

            <Button type="submit" class="mt-4 w-full" :tabindex="5" :disabled="form.processing">
                <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                Criar Conta
            </Button>
        </div>

        <div class="text-muted-foreground text-center text-sm">
            Já tem uma conta?
            <Link
                :href="route('get.auth.login')"
                class="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
            >
                Entrar
            </Link>
        </div>
    </form>
</template>
