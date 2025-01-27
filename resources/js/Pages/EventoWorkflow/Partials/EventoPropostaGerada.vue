<template>
    <div class="text-center">Como deseja enviar a proposta?</div>

    <div class="grid grid-cols-2 gap-2">
        <Button label="Download Word" class="mdi mdi-microsoft-word" icon-class="text-2xl" @click="downloadWord" />
        <Button label="Download PDF" class="mdi mdi-file-pdf-box" icon-class="text-2xl" @click="downloadPdf" />

        <Button label="E-mail " class="mdi mdi-email-fast" icon-class="text-2xl" severity="info" />
        <Button label="WhatsApp" class="mdi mdi-whatsapp" icon-class="text-2xl" severity="info" />

        <Button
            label="Editar dados"
            class="mdi mdi-pen"
            icon-class="text-2xl"
            severity="warn"
            @click="editarProposta"
        />
    </div>

    <div class="flex"></div>
</template>

<script setup>
import { router } from "@inertiajs/vue3";

const props = defineProps({ evento: Object });

function editarProposta() {
    router.post(route("evento-workflow.editar-proposta", { evento: props.evento.id }));
}

function downloadPdf() {
    const url = route("evento-workflow.download-pdf", { evento: props.evento.id });
    window.open(url, "_blank");
}

function downloadWord() {
    const url = route("evento-workflow.download-word", { evento: props.evento.id });
    window.open(url, "_blank");
}
</script>
