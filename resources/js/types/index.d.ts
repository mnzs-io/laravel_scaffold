import type { PageProps } from '@inertiajs/core';
import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';
import { Association, LaravelRole } from './server/laravel_types';

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavGroup {
    title: string;
    slug: string;
    href?: string;
    url?: string;
    icon: LucideIcon;
    isActive?: boolean;
    roles: LaravelRole[] | '*' | 'none';
    except?: LaravelRole[];
    items?: NavItem[];
}

export interface NavItem {
    title: string;
    href: string;
    url: string;
    icon?: LucideIcon;
    isActive?: boolean;
    roles: LaravelRole[] | '*' | 'none';
    except?: LaravelRole[];
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
    active: boolean;
    avatar: string;
    email_verified_at: string | null;
    created_at: string | null;
    updated_at: string | null;
    associations: Association[];
}

export type BreadcrumbItemType = BreadcrumbItem;
