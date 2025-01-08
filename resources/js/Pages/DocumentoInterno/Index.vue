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

            <Accordion :value="['0']" multiple>
                <AccordionPanel v-for="tab in categorias" :key="tab.nome" :value="tab.id">
                    <AccordionHeader>{{ tab.nome }}</AccordionHeader>
                    <AccordionContent>
                        <div class="flex flex-wrap gap-2">
                            <DocumentoCard
                                v-for="documento in documentosFiltrados.filter((doc) => doc.categoria_id == tab.id)"
                                :key="documento.id"
                                :documento="documento"
                            />
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
import DocumentoCard from "@/Components/DocumentoInterno/DocumentoCard.vue";
import TituloCard from "@/Components/TituloCard.vue";
import { Head } from "@inertiajs/vue3";
import { visitModal } from "@inertiaui/modal-vue";

const props = defineProps({
    artistas: Array,
    categorias: Array,
    documentos: Array,
});

const loadingModal = ref(false);

const documentosFiltrados = computed(() => {
    return props.documentos.filter((doc) => {
        if (!filtroArtista.value) return true;
        if (filtroArtista.value.value == 0) return true;
        return doc.artista_id == filtroArtista.value.value;
    });
});

const filtroArtista = ref({ name: "Todos artistas", value: 0 });
const options = ref([
    { name: "Todos artistas", value: 0 },
    ...props.artistas.map((artista) => ({ name: artista.nome, value: artista.id })),
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
