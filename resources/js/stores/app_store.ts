import { defineStore } from 'pinia';

export const useAppStore = defineStore('app', () => {
    const name = import.meta.env.VITE_APP_NAME;
    const logo = import.meta.env.VITE_APP_LOGO;

    return {
        name,
        logo,
    };
});
