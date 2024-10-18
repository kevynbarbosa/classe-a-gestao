import "../css/app.css";
import "./bootstrap";

import { createInertiaApp } from "@inertiajs/vue3";
import { createApp, h } from "vue";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";

import { ModalRoot } from "@inertiaui/modal-vue";

import { definePreset } from "@primevue/themes";
import Aura from "@primevue/themes/aura";
import PrimeVue from "primevue/config";
import DialogService from "primevue/dialogservice";
import ToastService from "primevue/toastservice";
import ptBrLocale from "./Config/pt-br-locale.json";
import DefaultLayout from "./Layouts/DefaultLayout.vue";

const appName = import.meta.env.VITE_APP_NAME || "";

const CustomTheme = definePreset(Aura, {
    // Your customizations, see the following sections for examples
    semantic: {
        primary: {
            50: "{yellow.50}",
            100: "{yellow.100}",
            200: "{yellow.200}",
            300: "{yellow.300}",
            400: "{yellow.400}",
            500: "{yellow.500}",
            600: "{yellow.600}",
            700: "{yellow.700}",
            800: "{yellow.800}",
            900: "{yellow.900}",
            950: "{yellow.950}",
        },
    },
});

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        let page = pages[`./Pages/${name}.vue`];
        page.default.layout = page.default.layout || DefaultLayout;
        return page;
    },
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(ModalRoot, () => h(App, props)) })
            .use(plugin)
            .use(ZiggyVue)
            .use(PrimeVue, {
                locale: ptBrLocale,
                theme: {
                    preset: CustomTheme,
                    options: {
                        darkModeSelector: ".dark-mode-active",
                    },
                },
            })
            .use(DialogService)
            .use(ToastService)
            .mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});
