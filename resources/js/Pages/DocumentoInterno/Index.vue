<template>
    <div>
        <Head title="Documentos" />

        <div class="card">
            <TituloCard titulo="Documentação interna (controle de versões)">
                <Button
                    label="Upload documento"
                    icon="mdi mdi-upload"
                    @click="uploadDocumento"
                    :loading="loadingModal"
                ></Button>
            </TituloCard>

            <div class="mb-4 flex justify-center">
                <SelectButton
                    v-model="filtroArtista"
                    :options="options"
                    optionLabel="name"
                    aria-labelledby="multiple"
                />
            </div>

            <div class="border-b border-gray-300">
                {{ categorias }}
            </div>

            {{ documentos }}

            <Accordion :value="['0']" multiple>
                <AccordionPanel v-for="tab in categorias" :key="tab.nome" :value="tab.id">
                    <AccordionHeader>{{ tab.nome }}</AccordionHeader>
                    <AccordionContent>
                        <div class="flex flex-wrap gap-2">
                            <div
                                v-for="i in 25"
                                :key="i"
                                class="flex min-w-24 max-w-48 cursor-pointer flex-col items-center justify-center gap-1 rounded bg-gray-200 p-2 hover:bg-gray-300 hover:shadow-sm"
                            >
                                <Button icon="mdi mdi-file-certificate" size="large" rounded></Button>
                                <div class="font-bold">Nome</div>
                                <div class="text-sm">12/05/2025</div>
                                <div class="text-sm font-light">Artista</div>
                            </div>
                        </div>
                    </AccordionContent>
                </AccordionPanel>
            </Accordion>

            <div class="mt-4 flex justify-center">
                <Button icon="mdi mdi-plus" label="Nova categoria" @click="novaCategoria"></Button>
            </div>
        </div>
    </div>
</template>

<script setup>
import TituloCard from "@/Components/TituloCard.vue";
import { Head } from "@inertiajs/vue3";
import { visitModal } from "@inertiaui/modal-vue";

const props = defineProps({
    artistas: Array,
    categorias: Array,
    documentos: Array,
});

const loadingModal = ref(false);

const filtroArtista = ref({ name: "Todos artistas", value: 0 });
const options = ref([
    { name: "Todos artistas", value: 0 },
    ...props.artistas.map((artista) => ({ name: artista.nome, value: artista.id })),
]);

const tabs = ref([
    { title: "Title 1", content: "Content 1", value: "0" },
    { title: "Title 2", content: "Content 2", value: "1" },
    { title: "Title 3", content: "Content 3", value: "2" },
]);

async function uploadDocumento() {
    loadingModal.value = true;
    await visitModal(`/documentos-internos/create`);
    loadingModal.value = false;
}

async function novaCategoria() {
    loadingModal.value = true;
    await visitModal(`/documentos-internos-categorias/create`);
    loadingModal.value = false;
}
</script>
