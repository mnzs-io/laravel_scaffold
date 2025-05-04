// Importações de estilos e dependências
import '../css/app.css';

import axios from 'axios';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

// 🌐 Echo + Pusher (usando Laravel Reverb)
declare global {
    interface Window {
        Echo: Echo<any>;
        Pusher: typeof Pusher;
    }
}

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});

// 🔐 Axios: configurações iniciais de CSRF e credenciais
axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';
axios.defaults.withCredentials = true;

// 🔁 Interceptor para lidar com erros 419 (CSRF expirado)
axios.interceptors.response.use(null, async (error) => {
    const originalRequest = error.config;

    if (error.response?.status === 419 && !originalRequest._retry) {
        originalRequest._retry = true;

        try {
            // Requisição para obter novo token
            const { data } = await axios.get('/csrf-token');
            const newToken = data.token;

            // Atualiza headers
            axios.defaults.headers.common['X-CSRF-TOKEN'] = newToken;
            originalRequest.headers['X-CSRF-TOKEN'] = newToken;

            // Atualiza a tag <meta> do DOM
            const meta = document.querySelector('meta[name="csrf-token"]');
            if (meta) {
                meta.setAttribute('content', newToken);
            }

            // Reenvia a request original
            return axios(originalRequest);
        } catch (e) {
            console.error('Erro ao tentar renovar o token CSRF:', e);
        }
    }

    return Promise.reject(error);
});
