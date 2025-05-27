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

const props = defineProps<{
    user: string;
    token: string;
    email: string;
}>();

const form = useForm({
    user: props.user,
    token: props.token,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('post.password.reset.signed'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Trocar a senha" />
    <form @submit.prevent="submit" class="flex flex-col gap-6">
        <div class="grid gap-6">
            <h1>Troca de senha de usuário: {{ email }}</h1>
            <div class="grid gap-2">
                <Label for="password">Senha</Label>
                <Input id="password" type="password" required :tabindex="3" autocomplete="new-password" v-model="form.password" placeholder="Senha" />
                <InputError v-if="form.errors.password">
                    {{ form.errors.password }}
                </InputError>

                <InputError v-if="form.errors.credentials">
                    {{ form.errors.credentials }}
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
            </div>

            <Button type="submit" class="mt-4 w-full" :tabindex="5" :disabled="form.processing">
                <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                Trocar Senha
            </Button>
        </div>

        <!-- TODO: Somente se puder se registrar -->
        <div class="text-muted-foreground text-center text-sm" v-if="register_enabled">
            Não tem uma conta?
            <Link
                :href="route('get.auth.register')"
                class="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
            >
                Cadastre-se
            </Link>
        </div>
    </form>
</template>
