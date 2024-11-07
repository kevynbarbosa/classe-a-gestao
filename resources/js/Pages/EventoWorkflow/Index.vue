<template>
    <Head title="Detalhes do evento" />

    <div class="card mx-auto max-w-2xl">
        <TituloCard titulo="Detalhes do evento" />

        <div class="my-2 grid grid-cols-2 gap-4 rounded bg-slate-100 p-2">
            <div>
                <b>Artista:</b>
                {{ evento.artista.nome }}
            </div>

            <div>
                <b>Contratante:</b>
                {{ evento.contratante.nome_completo }}
            </div>

            <div>
                <b>Data e hora:</b>
                {{ dateTimeLocale(evento.data_hora) }}
            </div>

            <div>
                <b>Vendedor:</b>
                {{ evento.vendedor.nome_completo }}
            </div>

            <div>
                <b>Cidade:</b>
                {{ evento.cidade_exterior || evento.cidade.nome }}
            </div>

            <div>
                <b>Recinto:</b>
                {{ evento.recinto }}
            </div>

            <div class="col-span-2 rounded border-x-4 border-green-700 bg-green-200 p-2 text-center">
                <b>Status do fluxo:</b>
                <br />
                {{ evento.status }}
            </div>
        </div>

        <FluxoEtapaControlador :evento="evento" />

        <Tabs value="timeline" class="mt-14">
            <TabList>
                <Tab value="contratante">Contratante</Tab>
                <Tab value="documentacao">Documentação</Tab>
                <Tab value="timeline">Timeline</Tab>
            </TabList>

            <TabPanel value="contratante">
                <EventoWorkflowContratante />
            </TabPanel>

            <TabPanel value="documentacao">
                <EventoWorkflowDocumentacao />
            </TabPanel>

            <TabPanel value="timeline">
                <EventoWorkflowTimeline />
            </TabPanel>
        </Tabs>
    </div>
</template>

<script setup>
import TituloCard from "@/Components/TituloCard.vue";
import { dateTimeLocale } from "@/Utils/dateUtils";
import { Head } from "@inertiajs/vue3";
import EventoWorkflowContratante from "./Partials/EventoWorkflowContratante.vue";
import EventoWorkflowDocumentacao from "./Partials/EventoWorkflowDocumentacao.vue";
import EventoWorkflowTimeline from "./Partials/EventoWorkflowTimeline.vue";
import FluxoEtapaControlador from "./Partials/FluxoEtapaControlador.vue";

const variable = ref(null);

const props = defineProps({ evento: Object });
</script>
