export type LaravelError = {
    status: number;
    message: string;
    errors?: Record<string, string[]>;
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
