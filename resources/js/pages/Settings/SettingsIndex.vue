<script setup lang="ts">
import AppLoading from '@/components/app/AppLoading.vue';
import { Card } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Switch } from '@/components/ui/switch';
import { useFlashMessages } from '@/composables/useFlashMessage';
import { Settings } from '@/types/server/laravel_types';
import { useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps<{
    settings: Array<Settings>;
}>();

const grouped = computed(() => {
    const groupedSettings: Record<string, typeof props.settings> = {};

    for (const setting of props.settings) {
        if (!groupedSettings[setting.group]) {
            groupedSettings[setting.group] = [];
        }
        groupedSettings[setting.group].push(setting);
    }

    const orderedGroups = [
        ...settingsOrder,
        ...Object.keys(groupedSettings)
            .filter((g) => !settingsOrder.includes(g))
            .sort(),
    ];

    const result: Record<string, typeof props.settings> = {};
    for (const group of orderedGroups) {
        result[group] = groupedSettings[group];
    }

    return result;
});

const submit = () => {
    form.post(route('post.settings.update'), {
        onSuccess: () => {
            // exibir mensagem ou ação custom
        },
    });
};

const form = useForm({
    setting: '',
});

const changingKey = ref('');

const flash = useFlashMessages();

const settingsOrder = ['Geral', 'Event Log'];

async function changeSettings(setting: Settings, newValue: any) {
    changingKey.value = setting.key;
    form.put(
        route('put.settings.update', {
            setting: setting.id,
            value: newValue,
        }),
        {
            onSuccess() {
                flash.success('Configuração atualizada com sucesso');
            },
            onError(error) {
                flash.error('Mensagem: ' + error, 'Erro ao atualizar a configuração');
            },
            onFinish() {
                changingKey.value = '';
            },
        },
    );
}
</script>

<template>
    <Head title="Configurações" />
    <Card class="mx-auto grid max-w-6xl min-w-96 grid-cols-2 gap-4 p-6">
        <template v-for="(settings, group) in grouped" :key="group">
            <!-- Título do grupo -->
            <div class="text-muted-foreground col-span-2 mt-6 border-b pb-1 text-lg font-semibold">
                {{ group }}
            </div>

            <!-- Campos do grupo -->
            <template v-for="setting in settings" :key="setting.key">
                <Label class="text-sm leading-none font-medium">
                    {{ setting.label }}
                </Label>
                <div class="flex items-center justify-center place-self-end">
                    <Transition mode="out-in" name="fade-slide-vertical">
                        <div v-if="changingKey === setting.key" class="pr-2">
                            <AppLoading :size="5" />
                        </div>
                        <div v-else>
                            <Switch
                                v-if="setting.type === 'boolean'"
                                :model-value="!!setting.value"
                                @update:model-value="(newValue) => changeSettings(setting, newValue)"
                            />
                            <Input v-if="setting.type === 'string'" :value="setting.value" @change="changeSettings" />
                        </div>
                    </Transition>
                </div>
            </template>
        </template>
    </Card>
</template>
