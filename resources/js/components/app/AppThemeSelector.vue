<script setup lang="ts">
import { useThemeStore } from '@/stores/theme_store';
import { Monitor, Moon, SunMedium } from 'lucide-vue-next';
import { computed } from 'vue';
const themeStore = useThemeStore();

const title = computed(() => {
    const currentInPt = themeStore.appearance === 'dark' ? 'Escuro' : themeStore.appearance === 'light' ? 'Claro' : 'Automático (mesmo do sistema)';
    return `Tema atual: ${currentInPt}`;
});
</script>

<template>
    <div class="flex items-center gap-2" :title="title">
        <Transition name="fade-and-slide-vertical" mode="out-in">
            <Moon
                key="moon"
                class="h-5 w-5 cursor-pointer text-gray-500 hover:text-gray-700"
                @click="themeStore.toggle"
                v-if="themeStore.appearance === 'dark'"
            />
            <SunMedium
                key="sun"
                class="h-5 w-5 cursor-pointer text-gray-500 hover:text-gray-700"
                @click="themeStore.toggle"
                v-else-if="themeStore.appearance === 'light'"
            />
            <Monitor
                key="auto"
                class="h-5 w-5 cursor-pointer text-gray-500 hover:text-gray-700"
                @click="themeStore.toggle"
                v-else="themeStore.appearance === 'system'"
            />
        </Transition>
    </div>
</template>

<style scoped>
.fade-and-slide-vertical-enter-active,
.fade-and-slide-vertical-leave-active {
    transition: all 0.2s ease-in-out;
}

.fade-and-slide-vertical-enter-from {
    opacity: 0;
    transform: translateY(-5px);
}

.fade-and-slide-vertical-leave-to {
    opacity: 0;
    transform: translateY(5px);
}

.fade-and-slide-vertical-enter-to,
.fade-and-slide-vertical-leave-from {
    opacity: 1;
    transform: translateY(0);
}
</style>
