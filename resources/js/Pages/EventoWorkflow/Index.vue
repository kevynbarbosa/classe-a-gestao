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
                {{ evento.data_hora }}
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

        <Tabs value="0">
            <TabList>
                <Tab value="0">Artista</Tab>
                <Tab value="4">Contratante</Tab>
                <Tab value="1">Documentação</Tab>
                <Tab value="2">Timeline</Tab>
            </TabList>
        </Tabs>
    </div>
</template>

<script setup>
import TituloCard from "@/Components/TituloCard.vue";
import { Head } from "@inertiajs/vue3";

const variable = ref(null);

const props = defineProps({ evento: Object });
</script>
