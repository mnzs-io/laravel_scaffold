import './bootstrap.ts';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';

// 🧭
import { ZiggyVue } from 'ziggy-js';

// 🍍
import { createPinia } from 'pinia';
const pinia = createPinia();

// ⚠️
import { todo } from './plugins/todo';

// 🌙 | ☀️
import AppLayout from './layouts/AppLayout.vue';
import { initializeTheme } from './stores/theme_store';

const appName = import.meta.env.VITE_APP_NAME;

const PROGRESS_COLOR = '#4B5563';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        return resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue')).then((page) => {
            if (!page.default.layout) {
                page.default.layout = AppLayout;
            }
            return page;
        });
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(todo)
            .use(pinia)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: PROGRESS_COLOR,
        // TODO: Cor do sistema!
    },
});
initializeTheme();
