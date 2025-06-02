import { NavGroup, NavItem, User } from '@/types';
import { LaravelRole, Roles } from '@/types/server/laravel_types';

import { Logs, Settings2, User2, Users2 } from 'lucide-vue-next';
export function useNav() {
    const main: NavGroup[] = [
        {
            title: 'Usuários',
            slug: '/usuarios',
            icon: Users2,
            roles: [Roles.ADMIN],
            href: route('get.users.index'),
            url: new URL(route('get.users.index')).pathname,
        },
        {
            title: 'Logs',
            slug: '/logs',
            icon: Logs,
            roles: [Roles.ADMIN],
            href: route('get.logs.index'),
            url: new URL(route('get.logs.index')).pathname,
        },
        {
            title: 'Configurações',
            slug: '/config',
            icon: Settings2,
            roles: [Roles.ADMIN],
            href: route('get.settings.index'),
            url: new URL(route('get.settings.index')).pathname,
        },
    ];

    const secondary: NavGroup[] = [];

    const user: NavItem[] = [
        {
            title: 'Perfil',
            href: route('get.profile'),
            url: new URL(route('get.profile')).pathname,
            icon: User2,
            roles: '*',
        },
    ];

    function shouldShow(user: User, authorizedRoles: LaravelRole[] | '*' | 'none'): boolean {
        if (authorizedRoles === '*') {
            return true;
            // TODO: Check except
        }

        if (authorizedRoles === 'none') {
            return false;
            // TODO: Check except
        }
        return user.roles.some((role) => {
            return authorizedRoles.some((authorized) => authorized === role);
        });
    }

    return {
        main,
        user,
        secondary,
        shouldShow,
    };
}
