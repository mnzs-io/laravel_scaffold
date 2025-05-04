import { usePage } from '@inertiajs/vue3';
import { AxiosError } from 'axios';
import { onMounted, watch } from 'vue';
import { toast } from 'vue-sonner';

export const useFlashMessages = () => {
    const page = usePage();

    const registerListener = () => {
        onMounted(() => {
            watch(
                () => page.props.flash,
                (flashMessage) => {
                    if (typeof flashMessage === 'string') {
                        const [level, message, title] = flashMessage.split('###');

                        const toastMethod = {
                            success,
                            info,
                            warning,
                            error,
                        }[level];

                        if (toastMethod) {
                            toastMethod(message, title || getTitle(level));
                        } else {
                            neutral(message, title || getTitle('neutral'));
                        }
                    }
                },
                { immediate: true },
            );
        });
    };
    const success = (body: string, title?: string) => {
        if (!title) {
            title = getTitle('success');
        }
        toast.success(title, {
            description: body,
            style: styles('success'),
            duration: 3000,
        });
    };

    const info = (body: string, title?: string) => {
        if (!title) {
            title = getTitle('info');
        }
        toast.info(title, {
            description: body,
            style: styles('info'),
            duration: 3000,
        });
    };

    const warning = (body: string, title?: string) => {
        if (!title) {
            title = getTitle('warning');
        }
        toast.warning(title, {
            description: body,
            style: styles('warning'),
            duration: 3000,
        });
    };

    const error = (error: string | AxiosError, title?: string) => {
        if (error instanceof Object) {
            const data = error.response?.data as { message?: string; error?: string };
            if (data?.message) {
                error = data.message;
            } else if (data?.error) {
                error = data.error;
            } else {
                error = error.message;
            }
        }

        if (!title) {
            title = getTitle('error');
        }

        toast.error(title, {
            description: error,
            style: styles('error'),
            duration: 3000,
        });
    };

    const neutral = (body: string, title?: string) => {
        if (!title) {
            title = getTitle('info');
        }
        toast(title, {
            description: body,
            duration: 3000,
        });
    };

    return { registerListener, success, info, warning, error, neutral };
};

function styles(level: string) {
    switch (level) {
        case 'success':
            return {
                background: '#d1fae5',
                color: '#065f46',
                border: '1px solid #6ee7b7',
            };
        case 'info':
            return {
                background: '#dbeafe',
                color: '#1e40af',
                border: '1px solid #93c5fd',
            };
        case 'warning':
            return {
                background: '#fef9c3',
                color: '#92400e',
                border: '1px solid #fde68a',
            };
        case 'error':
            return {
                background: '#fee2e2',
                color: '#991b1b',
                border: '1px solid #fca5a5',
            };
        default:
            return {
                background: '#f3f4f6',
                color: '#1f2937',
                border: '1px solid #d1d5db',
            };
    }
}

function getTitle(level: string) {
    switch (level) {
        case 'success':
            return 'Sucesso!';
        case 'info':
            return 'Informação:';
        case 'warning':
            return 'Atenção!';
        case 'error':
            return 'Erro!';
        default:
            return 'Informação:';
    }
}
