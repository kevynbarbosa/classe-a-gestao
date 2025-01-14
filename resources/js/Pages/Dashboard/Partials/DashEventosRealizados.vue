<template>
    <div class="card h-min">
        <TituloCard titulo="Eventos realizados (por artista)">
            <Button label="Link" icon="mdi mdi-open-in-new" size="small"></Button>
        </TituloCard>

        <GridEventosArtista :dados="eventos_realizados_artista" />
    </div>
</template>

<script setup>
import GridEventosArtista from "@/Components/Dashboard/GridEventosArtista.vue";
import TituloCard from "@/Components/TituloCard.vue";

const props = defineProps({ eventos_realizados_artista: Array });

const variable = ref(null);
</script>
