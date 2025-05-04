import { NavGroup, NavItem, User } from '@/types';
import { LaravelRole, Roles } from '@/types/server/laravel';

import { User2, Users2 } from 'lucide-vue-next';
export function useNav() {
    const main: NavGroup[] = [
        {
            title: 'Usuários',
            slug: '/usuarios',
            icon: Users2,
            roles: [Roles.ADMIN],
            items: [
                {
                    title: 'Lista',
                    href: route('get.users.index'),
                    roles: [Roles.ADMIN],
                },
            ],
        },
    ];

    const secondary: NavGroup[] = [];

    const user: NavItem[] = [
        {
            title: 'Perfil',
            href: route('get.profile'),
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
