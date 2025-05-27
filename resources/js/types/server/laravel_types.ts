export type LaravelError = {
    status: number;
    message: string;
    errors?: Record<string, string[]>;
};

export type RoleWithId = {
    id: number;
    name: LaravelRole;
};

export type LaravelRole = 'ADMIN' | 'CLIENT';

export const Roles: Record<string, LaravelRole> = {
    ADMIN: 'ADMIN',
    CLIENT: 'CLIENT',
};

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
