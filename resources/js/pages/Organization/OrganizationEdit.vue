<script setup lang="ts">
import InputError from '@/components/input/InputError.vue';
import AvatarEdit from '@/components/profile/AvatarEdit.vue';
import { Button } from '@/components/ui/button';
import { Card } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { useFlashMessages } from '@/composables/useFlashMessage';
import { Organization } from '@/types/memory_cards';
import { router, useForm } from '@inertiajs/vue3';

const flash = useFlashMessages();

const props = defineProps<{
    organization: Organization;
}>();

const form = useForm({
    name: props.organization?.name || '',
    slug: props.organization?.slug || '',
    color: props.organization?.color || '',
    logo_url: props.organization?.logo_url || '',
});

const submit = () => {
    form.put(route('put.organization.data', { id: props.organization.id }), {
        preserveState: true,
        onSuccess() {
            flash.success('Organização atualizada com sucesso!');
            router.reload();
        },
        onError(e) {
            flash.error(e.message, 'Erro ao atualizar a organização.');
        },
    });
};
</script>

<template>
    <Card class="col-span-1 grid auto-rows-min gap-6 p-4">
        <form @submit.prevent="submit" class="grid grid-cols-1 gap-4">
            <h2 class="text-lg font-semibold">Editar Organização</h2>

            <!-- Logo -->
            <div class="grid gap-2">
                <Label for="logo">Logo</Label>
                <AvatarEdit v-model="form.logo_url" :initials="organization?.name[0] ?? '?'" :currentSavedImage="organization.logo_url || null" />
                <InputError v-if="form.errors.logo_url">{{ form.errors.logo_url }}</InputError>
            </div>

            <!-- Nome -->
            <div class="grid gap-2">
                <Label for="name">Nome</Label>
                <Input id="name" type="text" required v-model="form.name" />
                <InputError v-if="form.errors.name">{{ form.errors.name }}</InputError>
            </div>

            <!-- Slug -->
            <div class="grid gap-2">
                <Label for="slug">Slug</Label>
                <Input id="slug" type="text" v-model="form.slug" />
                <InputError v-if="form.errors.slug">{{ form.errors.slug }}</InputError>
            </div>

            <!-- Cor -->
            <div class="grid gap-2">
                <Label for="color">Cor</Label>
                <Input id="color" type="color" v-model="form.color" />
                <InputError v-if="form.errors.color">{{ form.errors.color }}</InputError>
            </div>

            <!-- Botão de salvar -->
            <Button type="submit" :disabled="form.processing" class="mt-4">
                <LoaderCircle v-if="form.processing" class="mr-2 h-4 w-4 animate-spin" />
                Salvar alterações
            </Button>
        </form>
    </Card>
</template>
