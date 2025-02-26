<template>
    <Head title="Detalhes do evento" />

    <div class="card mx-auto max-w-2xl">
        <TituloCard titulo="Detalhes do evento">
            <Button size="small" @click="downloadLoteDocumentos">Download de documentos</Button>
        </TituloCard>

        <div class="my-2 grid grid-cols-2 gap-4 rounded bg-slate-100 p-2 dark:bg-slate-800">
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

            <div>
                <b>Valor:</b>
                {{ decimalLocale(evento.valor) }}
            </div>

            <div class="col-span-2 rounded border-x-4 border-green-900 bg-green-200 p-2 text-center dark:bg-green-600">
                <b>Status do fluxo:</b>
                <br />
                {{ findEnumValue(evento_status_enum, evento.status) }}
            </div>

            <LinkProposta :evento="evento" />
        </div>

        <FluxoEtapaControlador :evento="evento" />

        <Tabs value="observacoes" class="mt-14">
            <TabList class="mb-4">
                <Tab value="observacoes">
                    Observações
                    <Badge severity="info" size="small" :value="evento.observacoes?.length"></Badge>
                </Tab>
                <Tab value="timeline">Timeline</Tab>
                <Tab value="contratante">Contratante</Tab>
                <!-- <Tab value="documentacao">Documentação</Tab> -->
            </TabList>

            <TabPanel value="observacoes">
                <EventoWorkflowObservacoes :evento="evento" />
            </TabPanel>

            <TabPanel value="contratante">
                <EventoWorkflowContratante :evento="evento" />
            </TabPanel>

            <TabPanel value="documentacao">
                <EventoWorkflowDocumentacao />
            </TabPanel>

            <TabPanel value="timeline">
                <EventoWorkflowTimeline :evento="evento" :evento_status_enum="evento_status_enum" />
            </TabPanel>
        </Tabs>
    </div>
</template>

<script setup>
import TituloCard from "@/Components/TituloCard.vue";
import { dateTimeLocale } from "@/Utils/dateUtils";
import { decimalLocale } from "@/Utils/decimalUtils";
import { findEnumValue } from "@/Utils/enumUtils";
import { Head } from "@inertiajs/vue3";
import { visitModal } from "@inertiaui/modal-vue";
import EventoWorkflowContratante from "./Partials/EventoWorkflowContratante.vue";
import EventoWorkflowDocumentacao from "./Partials/EventoWorkflowDocumentacao.vue";
import EventoWorkflowObservacoes from "./Partials/EventoWorkflowObservacoes.vue";
import EventoWorkflowTimeline from "./Partials/EventoWorkflowTimeline.vue";
import FluxoEtapaControlador from "./Partials/FluxoEtapaControlador.vue";
import LinkProposta from "./Partials/LinkProposta.vue";

const props = defineProps({ evento: Object, evento_status_enum: Array });

function downloadLoteDocumentos() {
    visitModal(route("documentos-internos.selecionar-lote-download", { evento: props.evento?.id }));
}
</script>
