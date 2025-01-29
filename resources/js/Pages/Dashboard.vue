<template>
    <Head title="Dashboard" />

    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
        <DashDocumentosInternos :documentos_internos="documentos_internos" />

        <!-- <DashCampanha /> -->

        <DashProximosEventos :proximos_eventos="proximos_eventos" />

        <DashEventosRealizados :eventos_realizados_artista="eventos_realizados_artista" />

        <DashEventosFuturos :eventos_futuros_artista="eventos_futuros_artista" />
    </div>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";
import DashDocumentosInternos from "./Dashboard/Partials/DashDocumentosInternos.vue";
import DashEventosFuturos from "./Dashboard/Partials/DashEventosFuturos.vue";
import DashEventosRealizados from "./Dashboard/Partials/DashEventosRealizados.vue";
import DashProximosEventos from "./Dashboard/Partials/DashProximosEventos.vue";

const props = defineProps({
    documentos_internos: Array,
    proximos_eventos: Array,
    campanhas: Array,
    eventos_realizados_artista: Array,
    eventos_futuros_artista: Array,
    eventos_totais_artista: Array,
});

const value = ref("");
</script>
