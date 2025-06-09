import { SharedData, User } from '@/types';
import { Association, LaravelRole } from '@/types/server/laravel_types';
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
    const associations: ComputedRef<Association[]> = computed(() => user.value?.associations || []);
    const initials: ComputedRef<string> = computed(() => getInitials(user.value?.name || ''));
    const isLoggedIn = computed(() => !!user.value);

    const visibleassociations = computed<LaravelRole[]>(() => {
        const list: Set<LaravelRole> = new Set();

        associations.value.forEach((association) => list.add(association.role));
        return Array.from(list) || [];
    });

    const hasRole = (role: LaravelRole): boolean => {
        return visibleassociations.value.includes(role);
    };

    const organizationToAdmin = computed(() => user.value.associations.find((a) => a.role === 'ADMIN')?.associable);

    return {
        associations,
        avatar,
        email,
        initials,
        isLoggedIn,
        name,
        organizationToAdmin,
        user,
        visibleassociations,
        hasRole,
    };
});
