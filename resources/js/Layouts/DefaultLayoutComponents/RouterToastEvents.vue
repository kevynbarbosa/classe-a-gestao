<template>
    <Toast position="bottom-center" group="router-loading">
        <template #container="{ message, closeCallback }">
            <div class="flex items-center gap-4 p-4 text-lg">
                <span class="mdi mdi-loading animate-spin"></span>

                <div>{{ message.detail }}</div>
            </div>
        </template>
    </Toast>
</template>

<script setup>
import { router } from "@inertiajs/vue3";
import { useToast } from "primevue/usetoast";

const toast = useToast();

var timeout = null;

router.on("start", () => {
    timeout = setTimeout(() => createToast(), 400);
});

router.on("finish", () => {
    clearTimeout(timeout);
    toast.removeGroup("router-loading");
});

function createToast() {
    toast.removeGroup("router-loading");

    toast.add({
        severity: "secondary",
        detail: "Carregando, aguarde...",
        group: "router-loading",
    });
}
</script>
