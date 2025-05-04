<script lang="ts">
export default {
    layout: GuestLayout,
};
</script>
<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Card } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Separator } from '@/components/ui/separator';
import { useFlashMessages } from '@/composables/useFlashMessage';
import GuestLayout from '@/layouts/GuestLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { Heart } from 'lucide-vue-next';

const flash = useFlashMessages();

const form = useForm({
    name: '',
});

function doLike() {
    form.post(route('post.like'), {
        onSuccess() {
            flash.success('Like enviado!');
        },
        onError(err) {
            flash.success(JSON.stringify(err));
        },
        onFinish() {},
    });
}
</script>

<template>
    <Card class="mx-auto mt-14 max-w-xl p-4">
        <Label>Nome:</Label>
        <Input v-model="form.name" />
        <Separator />
        <Button @click="doLike"> <Heart />Like! </Button>
    </Card>
</template>

<style scoped></style>
