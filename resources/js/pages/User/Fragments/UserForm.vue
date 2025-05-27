<script setup lang="ts">
import RoleBadgeGroup from '@/components/badges/RoleBadgeGroup.vue';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Switch } from '@/components/ui/switch';
import { getInitials } from '@/stores/auth_store';
import { User } from '@/types';
import { RoleWithId } from '@/types/server/laravel_types';
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

const hasSelected: ComputedRef<boolean> = computed(() => {
    return !!props.user;
});

function cancel() {
    emit('canceled');
}

const rolesWithId = computed(() => {
    return props.user?.roles as RoleWithId[];
});
</script>

<template>
    <Dialog v-model:open="hasSelected" @update:open="cancel">
        <DialogTrigger as-child />
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Editar Usuário</DialogTitle>
            </DialogHeader>
            <div class="my-2 grid grid-cols-3 content-start gap-2">
                <div>
                    <Label class="mb-1 cursor-pointer" for="avatar">Avatar</Label>
                    <Avatar class="h-8 w-8 rounded-lg">
                        <AvatarImage :src="$getUserImage(user?.avatar || '')" :alt="user?.name" />
                        <AvatarFallback class="rounded-lg">
                            {{ getInitials(user?.name) }}
                        </AvatarFallback>
                    </Avatar>
                </div>
                <div class="justify-self-center">
                    <Label class="mb-1">Perfis</Label>
                    <RoleBadgeGroup :roles="rolesWithId" />
                </div>
                <div class="justify-self-end">
                    <div class="flex flex-col space-x-2">
                        <Label class="mb-1 cursor-pointer" for="active">Ativo</Label>
                        <Switch class="cursor-pointer" id="active" v-model="form.active" />
                    </div>
                </div>
            </div>
            <div>
                <Label class="cursor-pointer" for="name">Nome</Label>
                <Input disabled id="name" v-model="form.name" type="text" class="mt-1 block w-full rounded-md border px-3 py-2" />
            </div>
            <div>
                <Label class="cursor-pointer" for="email">Email</Label>
                <Input disabled id="email" v-model="form.email" type="email" class="mt-1 block w-full rounded-md border px-3 py-2" />
            </div>
        </DialogContent>
    </Dialog>
</template>
