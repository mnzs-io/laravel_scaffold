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

defineProps<{
    register_enabled: boolean;
}>();

const form = useForm({
    email: 'devmenezes@outlook.com',
    password: '12345678',
    remember: false,
});

const submit = () => {
    form.post(route('post.auth.login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Log in" />

    <form @submit.prevent="submit" class="flex flex-col gap-6">
        <div class="grid gap-6">
            <div class="grid gap-2">
                <Label for="email">E-mail</Label>
                <Input
                    id="email"
                    type="email"
                    required
                    autofocus
                    :tabindex="1"
                    autocomplete="email"
                    v-model="form.email"
                    placeholder="email@example.com"
                />
                <InputError v-if="form.errors.email">
                    {{ form.errors.email }}
                </InputError>
            </div>

            <div class="grid gap-2">
                <!-- <div class="flex items-center justify-between">
                    <Label for="password">Senha</Label>
                    <Link :href="route('password.request')" class="text-sm" :tabindex="5"> Forgot password? </Link>
                </div> -->
                <Input
                    id="password"
                    type="password"
                    required
                    :tabindex="2"
                    autocomplete="current-password"
                    v-model="form.password"
                    placeholder="Password"
                />
            </div>

            <!-- TODO: Verificar como e porque tem isso -->
            <!-- <div class="flex items-center justify-between">
                <Label for="remember" class="flex items-center space-x-3">
                    <Checkbox id="remember" v-model="form.remember" :tabindex="3" />
                    <span>Remember me</span>
                </Label>
            </div> -->

            <Button type="submit" class="mt-4 w-full" :tabindex="4" :disabled="form.processing">
                <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                Entrar
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
