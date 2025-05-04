<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Card } from '@/components/ui/card';
import { useFlashMessages } from '@/composables/useFlashMessage';
import { getCookie } from '@/lib/cookie';
import { Head, useForm } from '@inertiajs/vue3';
import { Heart } from 'lucide-vue-next';
import { UUIDTypes, v4 as uuidv4 } from 'uuid';
import { ref, Ref } from 'vue';

interface Like {
    name: string;
    id?: UUIDTypes;
}

const flash = useFlashMessages();

const likes: Ref<Like[]> = ref([]);

window.Echo.channel('likes').listen('.like.received', (like: Like) => {
    flash.info(`${like.name}, deu like`);

    likes.value.push({
        ...like,
        id: uuidv4(),
    });
});

const token = getCookie('XSRF-TOKEN');
console.log('token');
console.log(token);

const form = useForm({});

async function doLike() {
    form.post(route('post.like.authenticated'));
}
</script>

<template>
    <Head title="Dashboard" />
    <div class="flex flex-col items-center justify-center space-y-4">
        <Button @click="doLike"> <Heart />Like! </Button>
        <Card class="w-full max-w-96 p-4">
            <p>Likes</p>
            <TransitionGroup name="list" tag="ul" class="relative overflow-x-hidden">
                <li class="flex space-x-2" v-for="like in likes" :key="like.id?.toString()">
                    <Heart class="fill-red-400 text-red-500" />
                    <span>
                        {{ like.name }}
                    </span>
                </li>
            </TransitionGroup>
        </Card>
    </div>
</template>

<style scoped>
.list-move, /* apply transition to moving elements */
.list-enter-active,
.list-leave-active {
    transition: all 0.5s ease;
}

.list-enter-from,
.list-leave-to {
    opacity: 0;
    transform: translateX(-10px);
}
.list-leave-active {
    position: absolute;
}
</style>
