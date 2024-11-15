<template>
    <div class="my-2 rounded bg-slate-100 p-2">
        <TituloCard titulo="Ação pendente do workflow do evento" />

        <EnviarFormularioContratante v-if="evento.status == 'formulario_pendente'" />

        <GerarPropostaContratante v-if="evento.status == 'pendente_proposta'" />

        <UploadNotaFiscal v-if="evento.status == 'pendente_nf'" />
    </div>
</template>

<script setup>
import TituloCard from "@/Components/TituloCard.vue";
import EnviarFormularioContratante from "./EnviarFormularioContratante.vue";
import GerarPropostaContratante from "./GerarPropostaContratante.vue";
import UploadNotaFiscal from "./UploadNotaFiscal.vue";

const props = defineProps({ evento: Object });
</script>
