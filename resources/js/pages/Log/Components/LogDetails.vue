<script setup lang="ts">
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { LogEntry } from '@/types/log_entry';
import { computed, h, ref } from 'vue';
import DeleteRenderer from './Renderers/DeleteRenderer.vue';
import InsertRenderer from './Renderers/InsertRenderer.vue';
import RawRenderer from './Renderers/RawRenderer.vue';
import ReadRenderer from './Renderers/ReadRenderer.vue';
import UpdateRenderer from './Renderers/UpdateRenderer.vue';

const props = defineProps<{
    log?: LogEntry;
}>();

const emit = defineEmits(['close']);

const renderer = computed(() => {
    if (!props.log) return h('span', 'Selecione um log');
    switch (props.log.type) {
        case 'raw':
            return RawRenderer;
        case 'update':
            return UpdateRenderer;
        case 'read':
            return ReadRenderer;
        case 'insert':
            return InsertRenderer;
        case 'delete':
            return DeleteRenderer;
        default:
            return h('span', 'Tipo desconhecido:' + JSON.stringify(props.log));
    }
});

const hasLogSelected = computed(() => !!props.log);

const resetAndClose = (open: boolean) => {
    if (!open) emit('close');
};

function formatDate(timestamp: number) {
    return new Intl.DateTimeFormat('pt-BR', {
        dateStyle: 'short',
        timeStyle: 'short',
    }).format(new Date(timestamp * 1000));
}

const loadingUserData = ref(false);
</script>

<template>
    <Dialog :open="hasLogSelected" @update:open="resetAndClose">
        <DialogContent class="h-[80vh] max-h-full w-[80vw] max-w-full" v-if="!log">
            <DcemBadge cor="red" icon="lucide:badge-alert"> Selecione um log </DcemBadge>
        </DialogContent>

        <DialogContent class="flex h-[80vh] max-h-full w-[80vw] max-w-full flex-col" v-else>
            <DialogHeader>
                <DialogTitle class="bg-muted mr-2 rounded-md px-4 py-2">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-thin">#{{ log._id }}</p>
                            <p class="my-2 flex flex-col items-start space-y-2">
                                <span>{{ log.description }}</span>
                                <span class="flex items-start space-x-2">
                                    <LogTypeBadge :type="log.type" />
                                    <LogLevelBadge :level="log.level" />
                                </span>
                            </p>
                        </div>
                        <div class="flex flex-col items-start space-y-1">
                            <p class="text-sm font-thin">{{ log.timestamp }}</p>
                            <span class="flex items-center space-x-1 text-base font-normal">
                                <Icon icon="lucide:clock" />
                                <span>{{ formatDate(log.timestamp) }}</span>
                            </span>
                            <span>{{ log.system }}</span>
                        </div>
                    </div>
                </DialogTitle>
                <DialogDescription>
                    <div class="flex items-center">
                        <p class="text-sm font-semibold">User: {{ log.user || '-' }}</p>
                    </div>
                </DialogDescription>
            </DialogHeader>

            <div class="flex flex-1 flex-col">
                <component :is="renderer" :log="log" class="flex-1" />
            </div>

            <DialogFooter class="grid grid-cols-2 p-2 text-sm">
                <template v-if="log.file">
                    <b>Class:</b>
                    <span class="ml-2">{{ log.file.replaceAll('\\', '/') }}</span>
                </template>
                <span v-else>Nenhum arquivo envolvido</span>

                <template v-if="log.file">
                    <b>Path:</b>
                    <span class="ml-2">{{ log.file.replace('/var/www/html', '') }}</span>
                </template>

                <template v-if="log.resources?.length">
                    <b>Resources:</b>
                    <span class="ml-2">
                        <ul class="list-disc pl-4">
                            <li v-for="(res, idx) in log.resources" :key="idx">{{ res.table }} #{{ res.id }}</li>
                        </ul>
                    </span>
                </template>
                <span v-else>Nenhum recurso envolvido</span>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

<style scoped></style>
