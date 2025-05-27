<script setup lang="ts">
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Dialog, DialogContent } from '@/components/ui/dialog';
import { SquarePen, XIcon } from 'lucide-vue-next';
import { ref } from 'vue';
import { Cropper } from 'vue-advanced-cropper';
import 'vue-advanced-cropper/dist/style.css';

const props = defineProps<{ initials: string; currentSavedImage: string | undefined }>();

const model = defineModel<string>();

const imageSrc = ref<string | null>(null);
const cropper = ref<any>(null);
const isEditing = ref(false);

const fileInput = ref<HTMLInputElement | null>(null);

function onFileChange(event: Event) {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files.length > 0) {
        const file = target.files[0];
        const reader = new FileReader();
        reader.onload = (e) => {
            imageSrc.value = e.target?.result as string;
            isEditing.value = true;
        };
        reader.readAsDataURL(file);
    }
}

function confirmCrop() {
    const canvas = cropper.value?.getResult()?.canvas;
    if (canvas) {
        model.value = canvas.toDataURL('image/png');
        isEditing.value = false;
    }
}

function resetImage() {
    if (model.value?.startsWith('data')) {
        model.value = props.currentSavedImage;
    } else {
        model.value = '';
    }
}
</script>

<template>
    <input type="file" accept="image/*" class="hidden" ref="fileInput" @change="onFileChange" />
    {{ model }}
    <Avatar class="group size-16 cursor-pointer rounded-lg" @click="fileInput?.click()">
        <Transition name="fade">
            <XIcon
                v-if="model !== ''"
                class="absolute top-0 right-0 rounded-lg bg-red-400 p-1 text-white opacity-75 transition-all group-hover:opacity-90 hover:opacity-100"
                @click.stop="resetImage"
            />
        </Transition>
        <AvatarImage :src="model || ''" />
        <AvatarFallback class="rounded-lg">{{ initials }}</AvatarFallback>
        <Transition name="fade">
            <SquarePen
                v-if="model !== ''"
                class="absolute right-0 bottom-0 rounded-lg bg-blue-400 p-1 text-white opacity-75 transition-all group-hover:opacity-90 hover:opacity-100"
                @click.stop="isEditing = true"
            />
        </Transition>
    </Avatar>

    <Dialog v-model:open="isEditing">
        <DialogContent>
            <Cropper
                ref="cropper"
                :src="imageSrc"
                :stencil-props="{ aspectRatio: 1, circular: true }"
                :canvas="{ width: 300, height: 300 }"
                class="mx-auto max-h-[300px] max-w-[300px]"
                style="width: 300px; height: 300px"
            />
            <button class="mt-4 rounded bg-blue-600 px-4 py-2 text-white" @click="confirmCrop">Confirmar recorte</button>
        </DialogContent>
    </Dialog>
</template>
