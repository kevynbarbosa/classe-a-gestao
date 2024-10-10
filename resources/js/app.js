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

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

const CustomTheme = definePreset(Aura, {
    // Your customizations, see the following sections for examples
    semantic: {
        primary: {
            50: "{violet.50}",
            100: "{violet.100}",
            200: "{violet.200}",
            300: "{violet.300}",
            400: "{violet.400}",
            500: "{violet.500}",
            600: "{violet.600}",
            700: "{violet.700}",
            800: "{violet.800}",
            900: "{violet.900}",
            950: "{violet.950}",
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
