<template>
    <div
        class="rounded bg-primary/10 py-4 text-center dark:bg-primary/20"
        v-if="!statusPropostaIndisponivel.includes(evento.status)"
    >
        <div class="mb-2 font-bold">Propostas geradas</div>
        <div class="flex w-full justify-center gap-2">
            <Button label="Download Word" class="mdi mdi-microsoft-word" icon-class="text-2xl" @click="downloadWord" />
            <Button label="Download PDF" class="mdi mdi-file-pdf-box" icon-class="text-2xl" @click="downloadPdf" />
        </div>

        <div class="mb-2 font-bold">Declaração geradas</div>
        <div class="flex w-full justify-center gap-2">
            <Button
                label="Download Word"
                class="mdi mdi-microsoft-word"
                icon-class="text-2xl"
                @click="downloadWordDeclaracao"
            />
            <Button
                label="Download PDF"
                class="mdi mdi-file-pdf-box"
                icon-class="text-2xl"
                @click="downloadPdfDeclaraca"
            />
        </div>

        <div class="mb-2 font-bold">Declaração econômicas geradas</div>
        <div class="flex w-full justify-center gap-2">
            <Button
                label="Download Word"
                class="mdi mdi-microsoft-word"
                icon-class="text-2xl"
                @click="downloadWordDeclaracaEconomica"
            />
            <Button
                label="Download PDF"
                class="mdi mdi-file-pdf-box"
                icon-class="text-2xl"
                @click="downloadPdfDeclaracaoEconomica"
            />
        </div>
    </div>
</template>

<script setup>
const props = defineProps({ evento: Object });

const statusPropostaIndisponivel = ["formulario_pendente", "formulario_enviado", "pendente_proposta"];

// Proposta

function downloadWord() {
    const url = route("download-modelo.word-proposta", { evento: props.evento.id }) + "?" + Date.now();
    window.open(url, "_blank");
}

function downloadPdf() {
    const url = route("download-modelo.pdf-proposta", { evento: props.evento.id }) + "?" + Date.now();
    window.open(url, "_blank");
}

// Declaracao
function downloadWordDeclaracao() {
    const url = route("download-modelo.word-declaracao", { evento: props.evento.id }) + "?" + Date.now();
    window.open(url, "_blank");
}

function downloadPdfDeclaraca() {
    const url = route("download-modelo.pdf-declaracao", { evento: props.evento.id }) + "?" + Date.now();
    window.open(url, "_blank");
}

// Declaracao economica
function downloadWordDeclaracaEconomica() {
    const url = route("download-modelo.word-declaracao-economica", { evento: props.evento.id }) + "?" + Date.now();
    window.open(url, "_blank");
}

function downloadPdfDeclaracaoEconomica() {
    const url = route("download-modelo.pdf-declaracao-economica", { evento: props.evento.id }) + "?" + Date.now();
    window.open(url, "_blank");
}
</script>
