import { SharedData, User } from '@/types';
import { LaravelRole } from '@/types/server/laravel';
import { usePage } from '@inertiajs/vue3';
import { defineStore } from 'pinia';
import { computed, ComputedRef } from 'vue';

export function getInitials(fullName?: string): string {
    if (!fullName) return '';

    const names = fullName.trim().split(' ');

    if (names.length === 0) return '';
    if (names.length === 1) return names[0].charAt(0).toUpperCase();

    return `${names[0].charAt(0)}${names[names.length - 1].charAt(0)}`.toUpperCase();
}

export const useAuthStore = defineStore('auth', () => {
    const page = usePage<SharedData>();

    const user: ComputedRef<User> = computed(() => page.props.user);
    const avatar: ComputedRef<string> = computed(() => user.value?.avatar || '');
    const name: ComputedRef<string> = computed(() => user.value?.name || '');
    const email: ComputedRef<string> = computed(() => user.value?.email || '');
    const roles: ComputedRef<LaravelRole[]> = computed(() => user.value?.roles || '');
    const initials: ComputedRef<string> = computed(() => getInitials(user.value?.name || ''));
    const isLoggedIn = computed(() => !!user.value);

    return {
        avatar,
        user,
        name,
        email,
        initials,
        isLoggedIn,
        roles,
    };
});
