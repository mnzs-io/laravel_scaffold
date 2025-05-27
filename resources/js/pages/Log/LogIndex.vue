<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { useFlashMessages } from '@/composables/useFlashMessage';
import { LogEntry } from '@/types/log_entry';
import { PaginatedResult } from '@/types/server/laravel_types';
import { Head, useForm } from '@inertiajs/vue3';
import { computed, Ref, ref, watch } from 'vue';
import LogsTable from '../User/Fragments/LogsTable.vue';
import LogDetails from './Components/LogDetails.vue';

// Define os tipos para os dados do log

const props = withDefaults(
    defineProps<{
        logs: PaginatedResult<LogEntry>;
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
    sistema: props.filters.sistema,
    tipo: props.filters.tipo,
    nivel: props.filters.nivel,
    usuario: props.filters.usuario,
    referencia: props.filters.referencia,
    page: 1,
});

const formValues = computed(() => {
    return [form.sistema, form.tipo, form.nivel, form.usuario, form.page, form.referencia];
});

watch(formValues, submit, { deep: true });

function reset() {
    form.sistema = '';
    form.tipo = '';
    form.nivel = '';
    form.usuario = '';
    form.referencia = '';
    form.page = 1;
}

function submit() {
    form.get(route('tech.transaction.logs'), {
        preserveScroll: true,
        preserveState: true,
        replace: true,
        only: ['logs'],
        onStart() {
            loading.value = true;
        },
        onFinish() {
            loading.value = false;
        },
    });
}

function mudarPagina(novaPagina: number) {
    form.page = novaPagina;
}
</script>

<template>
    <div class="w-full flex-1">
        <Head title="Logs de Negócio" />
        <h1 class="pageTitle">Logs de Negócio</h1>
        <form class="my-6 grid grid-cols-6 items-end gap-4" @submit.prevent="submit">
            <Select v-model="form.nivel" :items="niveisLog" label="Nível" placeholder="Selecione um tipo" all-options />
            <Select v-model="form.tipo" :items="tiposLog" label="Tipo" placeholder="Selecione um tipo" all-options />
            <Select v-model="form.sistema" :items="sistemasLog" label="Sistema" placeholder="Selecione um sistema" all-options />
            <Input v-model.lazy="form.usuario" label="Usuário (identidade)" placeholder="Ex.: 0123456789" />
            <Input v-model.lazy="form.referencia" label="referencia (tabela#id)" placeholder="Ex.: sucem2.universo#123" />
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
        <LogDetails :log="logSelecionado" @close="unselect" />
        <LogsTable :logs />
    </div>
</template>
