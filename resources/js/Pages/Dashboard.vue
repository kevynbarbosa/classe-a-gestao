<template>
    <Head title="Dashboard" />

    <div class="grid grid-cols-3 gap-4">
        <div class="card h-min">
            <TituloCard titulo="Documentação interna (avisos)">
                <Button
                    label="Link"
                    icon="mdi mdi-open-in-new"
                    size="small"
                    @click="router.visit('/documentos-internos')"
                ></Button>
            </TituloCard>
            <div class="max-h-96 overflow-y-auto">
                <DocumentoCard
                    v-for="documento in documentos_internos"
                    :key="documento.id"
                    :documento="documento"
                    dashboard
                />
            </div>
        </div>

        <div class="card h-min">
            <TituloCard titulo="Estatísticas de campanha">
                <Button label="Link" icon="mdi mdi-open-in-new" size="small"></Button>
            </TituloCard>
        </div>

        <div class="card h-min">
            <TituloCard titulo="Próximos eventos">
                <Button label="Link" icon="mdi mdi-open-in-new" size="small"></Button>
            </TituloCard>

            <div class="max-h-96 overflow-y-auto">
                <EventoDashboardCard v-for="evento in proximos_eventos" :key="evento.id" :evento="evento" />
            </div>
        </div>

        <div class="card h-min">
            <TituloCard titulo="Eventos realizados (por artista)">
                <Button label="Link" icon="mdi mdi-open-in-new" size="small"></Button>
            </TituloCard>

            <GridEventosArtista :dados="eventos_realizados_artista" />
        </div>

        <div class="card h-min">
            <TituloCard titulo="Eventos futuros (por artista)">
                <Button label="Link" icon="mdi mdi-open-in-new" size="small"></Button>
            </TituloCard>

            <GridEventosArtista :dados="eventos_futuros_artista" />
        </div>
    </div>
</template>

<script setup>
import GridEventosArtista from "@/Components/Dashboard/GridEventosArtista.vue";
import DocumentoCard from "@/Components/DocumentoInterno/DocumentoCard.vue";
import EventoDashboardCard from "@/Components/Evento/EventoDashboardCard.vue";
import TituloCard from "@/Components/TituloCard.vue";
import { Head, router } from "@inertiajs/vue3";

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
