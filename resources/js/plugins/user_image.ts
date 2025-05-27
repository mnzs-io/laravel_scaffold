import { Plugin } from 'vue';

export const getUserImage: Plugin = {
    install: (app) => {
        app.config.globalProperties.$getUserImage = (filename: string) => {
            if (filename) {
                return route('get.user.image', {
                    filename,
                });
            }
            return '';
        };
    },
};
