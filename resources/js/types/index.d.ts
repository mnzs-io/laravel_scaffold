import type { PageProps } from '@inertiajs/core';
import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';
import { LaravelRole } from './server/laravel';

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavGroup {
    title: string;
    slug: string;
    href?: string;
    icon: LucideIcon;
    isActive?: boolean;
    roles: Roles[] | '*' | 'none';
    except?: Roles[];
    items?: NavItem[];
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
    roles: Roles[] | '*' | 'none';
    except?: Roles[];
}

export interface Breadcrumb {
    title: string;
    href: string;
}

export interface SharedData extends PageProps {
    user: User;
    breadcrumbs: Breadcrumb[];
    ziggy: Config & { location: string };
}

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string | null;
    updated_at: string | null;
    roles: LaravelRole[];
}

export type BreadcrumbItemType = BreadcrumbItem;
