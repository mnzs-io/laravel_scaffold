<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { useFlashMessages } from '@/composables/useFlashMessage';
import { LogEntry } from '@/types/log_entry';
import { PaginatedResult } from '@/types/server/laravel_types';
import { Head, useForm } from '@inertiajs/vue3';
import { Ref, ref } from 'vue';
import LogsTable from '../User/Fragments/LogsTable.vue';
import LogDetails from './Components/LogDetails.vue';
import LogLevelSelect from './Components/Selects/LogLevelSelect.vue';
import LogTypeSelect from './Components/Selects/LogTypeSelect.vue';

// Define os tipos para os dados do log

const props = withDefaults(
    defineProps<{
        result: PaginatedResult<LogEntry>;
        filters: {
            tipo: string;
            nivel: string;
            sistema: string;
            usuario: string;
            referencia: string;
            page: number;
        };
    }>(),
    {},
);

// usePoll(5000, {
//     only: ['logs'],
// })

const flash = useFlashMessages();

// watch(
//     () => props.logs.meta['query_time'],
//     (queryTime) => {
//         flash.info(`A query foi executar em ${queryTime} ms e o método em ${props.logs.meta['method_time']} ms`);
//     },
// );

const loading = ref(false);

const logSelecionado: Ref<LogEntry | undefined> = ref();

function select(entry: LogEntry) {
    logSelecionado.value = entry;
}

function unselect() {
    logSelecionado.value = undefined;
}

const form = useForm({
    tipo: props.filters.tipo,
    nivel: props.filters.nivel,
    usuario: props.filters.usuario,
    page: 1,
});

function reset() {
    form.tipo = '';
    form.nivel = '';
    form.usuario = '';
    form.page = 1;
}

function submit() {
    form.get(route('tech.transaction.logs'), {
        preserveScroll: true,
        preserveState: true,
        replace: true,
        only: ['result'],
        onStart() {
            loading.value = true;
        },
        onFinish() {
            loading.value = false;
        },
    });
}
</script>

<template>
    <div class="w-full flex-1">
        <Head title="Logs de Negócio" />
        <h1 class="pageTitle">Logs de Negócio</h1>
        <div class="mx-auto w-full max-w-7xl items-center justify-center sm:px-6 lg:px-8">
            <form class="my-6 grid grid-cols-2 items-center justify-stretch gap-4 lg:grid-cols-4" @submit.prevent="submit">
                <LogLevelSelect />
                <LogTypeSelect />
                <div class="!-mt-2 flex flex-col justify-end space-y-2">
                    <Label>Usuário (e-mail)</Label>
                    <Input v-model.lazy="form.usuario" label="Usuário (identidade)" placeholder="Ex.: cliente@gmail.com" />
                </div>
                <span class="flex items-center space-x-2">
                    <Button class="min-w-24 justify-self-start" :disabled="form.processing">
                        <Transition mode="out-in" name="fade-slide-vertical">
                            <span v-if="form.processing">
                                <DcemLoading :with-icon="false" spin-color="gray" :size="8" />
                            </span>
                            <span v-else>Buscar</span>
                        </Transition>
                    </Button>
                    <Button type="button" variant="link" class="ml-2 justify-self-start" @click="reset" :disabled="form.processing">Reset</Button>
                </span>
            </form>
        </div>

        <LogDetails :log="logSelecionado" @close="unselect" />
        <LogsTable :result />
    </div>
</template>
