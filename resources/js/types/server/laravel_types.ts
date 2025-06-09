export type LaravelError = {
    status: number;
    message: string;
    errors?: Record<string, string[]>;
};

export type LaravelRole = 'ADMIN' | 'CLIENT' | 'SUPER_ADMIN' | 'TEACHER';

export const Role: Record<string, LaravelRole> = {
    ADMIN: 'ADMIN',
    CLIENT: 'CLIENT',
    SUPER_ADMIN: 'SUPER_ADMIN',
    TEACHER: 'TEACHER',
};
export interface Association {
    id: number;
    role: LaravelRole;
    associable?: {
        id: string;
        name: string;
        slug?: string;
        [key: string]: any;
    };
    alias?: string;
}

export interface LaravelLoginResponse {
    access_token: string;
    token_type: string;
    expires_in: number;
    user: {
        name: string;
        email: string;
        id: string;
    };
}

export interface PaginatedResult<T> {
    current_page: number;
    data: Array<T> | [];
    meta: {
        current_page: number;
        from: number;
        to: number;
        total: number;
        last_page: number;
        links: PaginateLink[];
        next_page_url: string;
        path: string;
        per_page: number;
        first_page_url: string;
        last_page_url: string;
        prev_page_url: string;
    };
    first_page_url: string;
    from: number;
    last_page: number;
    last_page_url: string;
    links: Array<PaginateLink>;
    next_page_url: string | null;
    path: string;
    per_page: number;
    prev_page_url: string | null;
    to: number;
    total: number;
}

export interface PaginateLink {
    url: string | null;
    label: string;
    active: boolean;
}

export interface Settings {
    id: number;
    group: string;
    type: string;
    key: string;
    label: string;
    value: string | boolean;
}

export interface User {
    id: string;
    name: string;
    email: string;
    avatar: string;
    active: boolean;
    email_verified_at: string | null;
    created_at: string | null;
    updated_at: string | null;

    associations: Association[];

    roles: LaravelRole[];
}
