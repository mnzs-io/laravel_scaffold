<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Switch } from '@/components/ui/switch';
import { User } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { computed, ComputedRef, watchEffect } from 'vue';

const props = defineProps<{
    user: User | undefined;
}>();

const emit = defineEmits(['saved', 'canceled']);

watchEffect(() => {
    if (props.user) Object.assign(form, { ...props.user });
});

const form = useForm({
    id: '',
    name: '',
    email: '',
    avatar: '',
    active: false,
    roles: [],
});

function submit() {
    console.log(form);
    emit('saved');
}

const hasSelected: ComputedRef<boolean> = computed(() => {
    return !!props.user;
});

function cancel() {
    emit('canceled');
}
</script>

<template>
    <Dialog v-model:open="hasSelected" @update:open="cancel">
        <DialogTrigger as-child />
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Editar Usuário</DialogTitle>
            </DialogHeader>

            <form @submit.prevent="submit" class="space-y-6">
                <div>
                    <Label class="cursor-pointer" for="name">Nome</Label>
                    <Input id="name" v-model="form.name" type="text" class="mt-1 block w-full rounded-md border px-3 py-2" />
                </div>
                <div>
                    <Label class="cursor-pointer" for="email">Email</Label>
                    <Input id="email" v-model="form.email" type="email" class="mt-1 block w-full rounded-md border px-3 py-2" />
                </div>
                <div>
                    <div class="flex items-center space-x-2">
                        <Switch class="cursor-pointer" id="active" v-model="form.active" />
                        <Label class="cursor-pointer" for="active">Ativo</Label>
                    </div>
                </div>
                <div>
                    <Label class="cursor-pointer" for="avatar">Avatar</Label>
                    <Input id="avatar" v-model="form.avatar" class="mt-1 block w-full rounded-md border px-3 py-2" />
                </div>
                <div>
                    <Label>Perfis</Label>
                    <RolesSelector v-model="form.roles" />
                </div>
                <DialogFooter>
                    <Button type="submit">Salvar</Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>
