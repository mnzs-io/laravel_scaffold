<script setup lang="ts">
import AddressDescription from '@/components/address/AddressDescription.vue';
import AddressForm from '@/components/address/AddressForm.vue';
import AvatarEdit from '@/components/profile/AvatarEdit.vue';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Switch } from '@/components/ui/switch';
import { getInitials } from '@/stores/auth_store';
import { User } from '@/types';
import { Organization } from '@/types/memory_cards';
import { useForm } from '@inertiajs/vue3';
import { computed, ComputedRef, watchEffect } from 'vue';

const props = withDefaults(
    defineProps<{
        organization: Organization | undefined;
        administrators: User[];
        editing: boolean;
    }>(),
    {
        editing: false,
    },
);

const emit = defineEmits(['saved', 'canceled']);

watchEffect(() => {
    if (props.organization) Object.assign(form, { ...props.organization });
});

const form = useForm({
    id: props.organization?.id ?? '',
    name: props.organization?.name ?? '',
    email: props.organization?.email ?? '',
    address: props.organization?.address
        ? { ...props.organization?.address }
        : {
              street: '',
              number: '',
              complement: '',
              neighborhood: '',
              city: '',
              state: '',
              postal_code: '',
              country: '',
          },
    active: props.organization?.active ?? false,
    logo_url: props.organization?.logo_url ?? '',
});

const hasSelected: ComputedRef<boolean> = computed(() => {
    return !!props.organization;
});

function cancel() {
    emit('canceled');
}

function save() {
    if (!props.editing) alert('Não deveria salvar');
    alert('save');
}
</script>

<template>
    <Dialog v-model:open="hasSelected" @update:open="cancel">
        <DialogTrigger as-child />
        <DialogContent>
            <DialogHeader>
                <DialogTitle v-if="editing">Editar Curso</DialogTitle>
                <DialogTitle>Curso {{ organization?.name }}</DialogTitle>
            </DialogHeader>
            <form @submit.prevent="save">
                <div class="my-2 grid grid-cols-3 content-start gap-4">
                    <div>
                        <Label class="mb-1 cursor-pointer" for="avatar">Logo</Label>
                        <AvatarEdit v-model="form.logo_url" v-if="editing" />
                        <Avatar class="h-8 w-8 rounded-lg" v-else>
                            <AvatarImage :src="organization?.logo_url || ''" :alt="organization?.name" />
                            <AvatarFallback class="rounded-lg">
                                {{ getInitials(organization?.name) }}
                            </AvatarFallback>
                        </Avatar>
                    </div>
                    <div class="justify-self-center">
                        <Label class="mb-1">Plano</Label>
                        <span>Básico</span>
                    </div>
                    <div class="justify-self-end">
                        <div class="flex flex-col space-x-2">
                            <Label class="mb-1 cursor-pointer" for="active">Ativo</Label>
                            <Switch :disabled="!editing" class="cursor-pointer" id="active" v-model="form.active" v-if="editing" />
                            <span v-else>
                                {{ organization?.active ? 'Sim' : 'Não' }}
                            </span>
                        </div>
                    </div>

                    <div class="col-span-full">
                        <Label class="cursor-pointer" for="name">Nome</Label>
                        <Input
                            :disabled="!editing"
                            id="name"
                            v-model="form.name"
                            type="text"
                            class="mt-1 block w-full rounded-md border px-3 py-2"
                            v-if="editing"
                        />
                        <p v-else>{{ organization?.name }}</p>
                        <p class="text-foreground/70 p-1 text-xs font-thin">Na URL: {{ organization?.slug }}</p>
                    </div>

                    <div class="col-span-full">
                        <Label class="cursor-pointer" for="name">E-mail</Label>
                        <Input
                            :disabled="!editing"
                            id="email"
                            v-model="form.email"
                            type="text"
                            class="mt-1 block w-full rounded-md border px-3 py-2"
                            v-if="editing"
                        />
                        <p v-else>
                            <span v-if="organization?.email">
                                {{ organization?.email }}
                            </span>
                            <span v-else class="text-destructive text-xs"> E-mail não cadastrado </span>
                        </p>
                    </div>
                    <div class="col-span-full">
                        <p class="col-span-full my-1 text-sm font-semibold">Endereço</p>
                        <AddressForm v-if="editing && organization?.address" :model-value="form.address" />
                        <AddressDescription v-else-if="organization?.address" :address="organization.address" />
                        <p v-else class="text-destructive text-xs">Endereço não cadastrado</p>
                    </div>
                </div>
                <div v-if="editing" class="col-span-full flex items-end justify-end">
                    <Button class="my-2">Salvar</Button>
                </div>
            </form>
        </DialogContent>
    </Dialog>
</template>
