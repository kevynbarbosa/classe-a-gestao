<template>
    <div
        class="col-span-2 rounded bg-primary/10 py-4 text-center"
        v-if="!statusPropostaIndisponivel.includes(evento.status)"
    >
        <div class="mb-2 font-bold">Propostas geradas</div>
        <div class="flex w-full justify-center gap-2">
            <Button label="Download Word" class="mdi mdi-microsoft-word" icon-class="text-2xl" @click="downloadWord" />
            <Button label="Download PDF" class="mdi mdi-file-pdf-box" icon-class="text-2xl" @click="downloadPdf" />
        </div>
    </div>
</template>

<script setup>
const props = defineProps({ evento: Object });

const statusPropostaIndisponivel = ["formulario_pendente", "formulario_enviado", "pendente_proposta"];
function downloadPdf() {
    const url = route("evento-workflow.download-pdf", { evento: props.evento.id }) + "?" + Date.now();
    window.open(url, "_blank");
}

function downloadWord() {
    const url = route("evento-workflow.download-word", { evento: props.evento.id }) + "?" + Date.now();
    window.open(url, "_blank");
}
</script>
