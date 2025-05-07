<script setup lang="ts">
interface UserData {
    [key: string]: any;
}

interface Payload {
    header: {
        class: string;
        message: string;
    };
    data: {
        antes: UserData;
        depois: UserData;
    };
    user: {
        id: string;
        name: string;
    } | null;
}

const payload: Payload = {
    header: {
        class: 'App/Actions/Auth/PutUpdateProfileData',
        message: 'Atualização de dados de usuário',
    },
    data: {
        antes: {
            id: '0196acc6-faba-734b-afc9-34fff0c32ea0',
            name: 'Rafael Menezes da Silva',
            email: 'devmenezes@outlook.com',
            avatar: null,
            email_verified_at: null,
            created_at: '2025-05-07T22:04:03.000000Z',
            updated_at: '2025-05-07T23:23:57.000000Z',
            active: true,
        },
        depois: {
            id: '0196acc6-faba-734b-afc9-34fff0c32ea0',
            name: 'Rafael Menezes',
            email: 'devmenezes@outlook.com',
            avatar: null,
            email_verified_at: null,
            created_at: '2025-05-07T22:04:03.000000Z',
            updated_at: '2025-05-07T23:27:28.000000Z',
            active: true,
        },
    },
    user: {
        id: '0196acc6-faba-734b-afc9-34fff0c32ea0',
        name: 'Rafael Menezes da Silva',
    },
};

function isDifferent(key: string): boolean {
    return payload.data.antes[key] !== payload.data.depois[key];
}

function formatValue(value: any): string {
    if (value === null) return 'null';
    if (typeof value === 'boolean') return value ? 'true' : 'false';
    return String(value);
}
</script>

<template>
    <div class="space-y-4 rounded border bg-white p-4 shadow">
        <!-- Cabeçalho -->
        <header class="border-b pb-2">
            <h1 class="text-lg font-semibold text-gray-800">{{ payload.header.message }}</h1>
            <p class="text-sm text-gray-500">{{ payload.header.class }}</p>
        </header>

        <!-- Conteúdo principal: Antes e Depois -->
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <!-- Antes -->
            <div class="rounded bg-red-50 p-4 shadow">
                <h2 class="mb-2 font-semibold text-red-800">Antes</h2>
                <ul class="space-y-1 text-sm">
                    <li v-for="(value, key) in payload.data.antes" :key="'antes-' + key">
                        <span class="text-gray-600">{{ key }}:</span>
                        <span :class="{ 'font-bold': isDifferent(key) }">{{ formatValue(value) }}</span>
                    </li>
                </ul>
            </div>

            <!-- Depois -->
            <div class="rounded bg-green-50 p-4 shadow">
                <h2 class="mb-2 font-semibold text-green-800">Depois</h2>
                <ul class="space-y-1 text-sm">
                    <li v-for="(value, key) in payload.data.depois" :key="'depois-' + key">
                        <span class="text-gray-600">{{ key }}:</span>
                        <span :class="{ 'font-bold': isDifferent(key) }">{{ formatValue(value) }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Rodapé -->
        <footer class="border-t pt-2 text-sm text-gray-600">
            Usuário responsável:
            <span class="font-medium" v-if="payload.user"> {{ payload.user.name }} ({{ payload.user.id }}) }} </span>
            <span v-else>Anônimo</span>
        </footer>
    </div>
</template>
