<template>
    <div
        class="rounded bg-primary/10 py-4 text-center dark:bg-primary/20"
        v-if="!statusPropostaIndisponivel.includes(evento.status)"
    >
        <EventoWorkflowDocumentacao :evento="evento" />
    </div>
</template>

<script setup>
import EventoWorkflowDocumentacao from "./EventoWorkflowDocumentacao.vue";

const props = defineProps({ evento: Object });

const statusPropostaIndisponivel = ["formulario_pendente", "formulario_enviado", "pendente_proposta"];
</script>
