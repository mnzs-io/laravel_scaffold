import { Plugin } from 'vue';

export const todo: Plugin = {
    install: (app) => {
        app.config.globalProperties.$todo = () => {
            alert('Pendente de implementação');
        };
    },
};
