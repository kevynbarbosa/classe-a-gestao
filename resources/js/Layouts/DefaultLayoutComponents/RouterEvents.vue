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

var toastReference = null;

router.on("start", () => {
    toast.removeGroup("router-loading");
    toast.add({
        severity: "secondary",
        // summary: "Success Message",
        detail: "Carregando conteúdo",
        group: "router-loading",
    });
});

router.on("finish", () => {
    toast.removeGroup("router-loading");
});
</script>
