<template>
    <Modal class="h-screen" ref="modalRef">
        <Head :title="titulo" />

        <TituloCard :titulo="titulo"></TituloCard>

        <Tabs value="0">
            <TabList>
                <Tab value="0">Dados gerais</Tab>
                <Tab value="1">Contratante</Tab>
                <Tab value="2">Proposta</Tab>
                <Tab value="3">Observações</Tab>
            </TabList>
            <TabPanels>
                <TabPanel value="0">
                    <div class="my-2 grid grid-cols-2 gap-4 rounded bg-slate-100 p-2">
                        <div>
                            <b>Artista:</b>
                            {{ evento.artista?.nome }}
                        </div>

                        <div>
                            <b>Contratante:</b>
                            {{ evento.contratante?.nome_completo }}
                        </div>

                        <div>
                            <b>Data e hora:</b>
                            {{ dateTimeLocale(evento.data_hora) }}
                        </div>

                        <div>
                            <b>Vendedor:</b>
                            {{ evento.vendedor?.nome_completo }}
                        </div>

                        <div>
                            <b>Cidade:</b>
                            {{ evento.cidade_exterior || evento.cidade?.nome }}
                        </div>

                        <div>
                            <b>Recinto:</b>
                            {{ evento.recinto }}
                        </div>

                        <div class="col-span-2 rounded border-x-4 border-green-700 bg-green-200 p-2 text-center">
                            <b>Status do fluxo:</b>
                            <br />
                            {{ findEnumValue(evento_status_enum, evento.status) }}
                        </div>
                    </div>
                </TabPanel>

                <TabPanel value="1">
                    <EventoWorkflowContratante :evento="evento" />
                </TabPanel>

                <TabPanel value="2">
                    <LinkProposta :evento="evento" />
                </TabPanel>

                <TabPanel value="3">
                    <EventoWorkflowObservacoes :evento="evento" />
                </TabPanel>
            </TabPanels>
        </Tabs>
    </Modal>
</template>

<script setup>
import TituloCard from "@/Components/TituloCard.vue";
import { dateTimeLocale } from "@/Utils/dateUtils";
import { findEnumValue } from "@/Utils/enumUtils";
import { Head } from "@inertiajs/vue3";
import { Modal } from "@inertiaui/modal-vue";
import EventoWorkflowContratante from "../EventoWorkflow/Partials/EventoWorkflowContratante.vue";
import EventoWorkflowObservacoes from "../EventoWorkflow/Partials/EventoWorkflowObservacoes.vue";
import LinkProposta from "../EventoWorkflow/Partials/LinkProposta.vue";

const props = defineProps({
    evento: Object,
    evento_status_enum: Array,
});

const titulo = "Detalhes do evento";

const variable = ref(null);
</script>
