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
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

const form = useForm({
    email: 'devmenezes@outlook.com',
});

const submit = () => {
    form.post(route('post.auth.forgot-password'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Esqueci a senha" />

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

            <Button type="submit" class="mt-4 w-full" :tabindex="4" :disabled="form.processing">
                <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                Solicitar e-mail
            </Button>
        </div>
    </form>
</template>
