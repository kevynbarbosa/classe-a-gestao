<template>
    <div class="card h-min">
        <TituloCard titulo="Próximos eventos">
            <Button label="Link" icon="mdi mdi-open-in-new" size="small"></Button>
        </TituloCard>

        <div class="max-h-96 overflow-y-auto">
            <EventoDashboardCard v-for="evento in proximos_eventos" :key="evento.id" :evento="evento" />
        </div>
    </div>
</template>

<script setup>
import EventoDashboardCard from "@/Components/Evento/EventoDashboardCard.vue";
import TituloCard from "@/Components/TituloCard.vue";

const props = defineProps({ proximos_eventos: Array });

const variable = ref(null);
</script>
