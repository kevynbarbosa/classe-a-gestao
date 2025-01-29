<template>
    <div class="my-2 rounded bg-slate-100 p-2 dark:bg-slate-800">
        <!-- <TituloCard titulo="Ação pendente do workflow do evento" /> -->

        <EnviarFormularioContratante v-if="evento.status == 'formulario_pendente'" :evento="evento" />

        <EventoFormularioReenviar v-if="evento.status == 'formulario_enviado'" :evento="evento" />

        <GerarPropostaContratante v-if="evento.status == 'pendente_proposta'" :evento="evento" />

        <EventoPropostaGerada v-if="evento.status == 'proposta_gerada'" :evento="evento" />

        <UploadNotaFiscal v-if="evento.status == 'pendente_nf'" :evento="evento" />
    </div>
</template>

<script setup>
import EnviarFormularioContratante from "./EnviarFormularioContratante.vue";
import EventoFormularioReenviar from "./EventoFormularioReenviar.vue";
import EventoPropostaGerada from "./EventoPropostaGerada.vue";
import GerarPropostaContratante from "./GerarPropostaContratante.vue";
import UploadNotaFiscal from "./UploadNotaFiscal.vue";

const props = defineProps({ evento: Object });
</script>
