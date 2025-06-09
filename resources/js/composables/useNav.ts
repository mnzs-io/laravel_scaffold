import { useAuthStore } from '@/stores/auth_store';
import { NavGroup, NavItem } from '@/types';
import { LaravelRole, Role } from '@/types/server/laravel_types';
import {
    BookMarked,
    BookOpenCheck,
    ClipboardList,
    FileText,
    GraduationCap,
    LayoutDashboard,
    ListChecks,
    Logs,
    Settings2,
    User2,
    Users2,
    Wallet,
} from 'lucide-vue-next';

export function useNav() {
    const auth = useAuthStore();

    const superAdminMenu: NavGroup[] = [
        {
            title: 'Dashboard',
            slug: '/admin/dashboard',
            icon: LayoutDashboard,
            roles: [Role.SUPER_ADMIN],
            href: route('get.dashboard'),
            url: new URL(route('get.dashboard')).pathname,
        },
        {
            title: 'Organizações',
            slug: '/organizacoes',
            icon: GraduationCap,
            roles: [Role.SUPER_ADMIN],
            href: route('get.organizations.index'),
            url: new URL(route('get.organizations.index')).pathname,
        },
        {
            title: 'Usuários',
            slug: '/usuarios',
            icon: Users2,
            roles: [Role.SUPER_ADMIN],
            href: route('get.users.index'),
            url: new URL(route('get.users.index')).pathname,
        },
    ];
    const adminMenu: NavGroup[] = [
        {
            title: 'Meu Curso',
            slug: '/curso',
            icon: GraduationCap,
            roles: [Role.ADMIN],
            href: auth.organizationToAdmin ? route('get.organization.edit', { organization: auth.organizationToAdmin?.slug }) : '#',
            url: auth.organizationToAdmin ? new URL(route('get.organization.edit', { organization: auth.organizationToAdmin?.slug })).pathname : '#',
        },
        {
            title: 'Professores',
            slug: '/professores',
            icon: BookMarked,
            roles: [Role.ADMIN],
            href: auth.organizationToAdmin ? route('get.teachers.index', { organization: auth.organizationToAdmin?.slug }) : '#',
            url: auth.organizationToAdmin ? new URL(route('get.teachers.index', { organization: auth.organizationToAdmin })).pathname : '#',
        },
        {
            title: 'Disciplinas',
            slug: '/disciplinas',
            icon: ClipboardList,
            roles: [Role.ADMIN],
            href: '#',
            url: '/disciplinas',
        },
        {
            title: 'Alunos',
            slug: '/alunos',
            icon: BookOpenCheck,
            roles: [Role.ADMIN],
            href: '#',
            url: '/alunos',
        },
        {
            title: 'Financeiro',
            slug: '/financeiro',
            icon: Wallet,
            roles: [Role.ADMIN],
            href: '#',
            url: '/financeiro',
        },
    ];

    const teacherMenu: NavGroup[] = [
        {
            title: 'Questões',
            slug: '/questoes',
            icon: FileText,
            roles: [Role.TEACHER],
            href: '#',
            url: '/questoes',
        },
        {
            title: 'Cards',
            slug: '/cards',
            icon: ListChecks,
            roles: [Role.TEACHER],
            href: '#',
            url: '/cards',
        },
    ];

    const studentMenu: NavGroup[] = [
        {
            title: 'Questões',
            slug: '/questoes',
            icon: FileText,
            roles: [Role.CLIENT],
            href: '#',
            url: '/questoes',
        },
        {
            title: 'Cards',
            slug: '/cards',
            icon: ListChecks,
            roles: [Role.CLIENT],
            href: '#',
            url: '/cards',
        },
    ];

    const secondaryRaw: NavGroup[] = [
        {
            title: 'Logs',
            slug: '/logs',
            icon: Logs,
            roles: [Role.ADMIN],
            href: route('get.logs.index'),
            url: new URL(route('get.logs.index')).pathname,
        },
        {
            title: 'Configurações',
            slug: '/config',
            icon: Settings2,
            roles: [Role.ADMIN],
            href: route('get.settings.index'),
            url: new URL(route('get.settings.index')).pathname,
        },
    ];

    const user: NavItem[] = [
        {
            title: 'Perfil',
            href: route('get.profile'),
            url: new URL(route('get.profile'), location.origin).pathname,
            icon: User2,
            roles: '*',
        },
    ];

    function shouldShow(authorizedRoles: LaravelRole[] | LaravelRole | '*' | 'none'): boolean {
        if (authorizedRoles === '*') return true;
        if (authorizedRoles === 'none') return false;
        if (typeof authorizedRoles === 'string') {
            return auth.visibleassociations.includes(authorizedRoles);
        }
        return authorizedRoles.some((role) => auth.visibleassociations.includes(role));
    }

    const secondary = secondaryRaw.filter((item: NavGroup) => shouldShow(item.roles));

    return {
        teacherMenu,
        studentMenu,
        adminMenu,
        superAdminMenu,
        user,
        secondary,
        shouldShow,
    };
}
