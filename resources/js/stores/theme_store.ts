import { useStorage } from '@vueuse/core';
import { defineStore } from 'pinia';

type Appearance = 'light' | 'dark' | 'system';
const list: Appearance[] = ['light', 'dark', 'system'];

export const useThemeStore = defineStore('theme', () => {
    const appearance = useStorage<Appearance>('appearance', 'system');

    function updateAppearance(value: Appearance) {
        appearance.value = value;
        setCookie('appearance', value);
        updateTheme(value);
    }

    function toggle() {
        if (typeof window === 'undefined') return;

        const nextIndex = (list.indexOf(appearance.value) + 1) % list.length;
        const nextAppearance = list[nextIndex];

        updateAppearance(nextAppearance);
    }

    return {
        appearance,
        updateAppearance,
        toggle,
    };
});

export function initializeTheme() {
    if (typeof window === 'undefined') return;

    const savedAppearance = localStorage.getItem('appearance') as Appearance | null;
    updateTheme(savedAppearance || 'system');
    mediaQuery()?.addEventListener('change', handleSystemThemeChange);
}

function handleSystemThemeChange() {
    const saved = localStorage.getItem('appearance') as Appearance | null;
    updateTheme(saved || 'system');
}

function updateTheme(value: Appearance) {
    if (typeof window === 'undefined') return;

    if (value === 'system') {
        const mediaQueryList = window.matchMedia('(prefers-color-scheme: dark)');
        const systemTheme = mediaQueryList.matches ? 'dark' : 'light';
        document.documentElement.classList.toggle('dark', systemTheme === 'dark');
    } else {
        document.documentElement.classList.toggle('dark', value === 'dark');
    }
}

function mediaQuery() {
    if (typeof window === 'undefined') return null;
    return window.matchMedia('(prefers-color-scheme: dark)');
}

function setCookie(name: string, value: string, days = 365) {
    if (typeof document === 'undefined') return;

    const maxAge = days * 24 * 60 * 60;
    document.cookie = `${name}=${value};path=/;max-age=${maxAge};SameSite=Lax`;
}
