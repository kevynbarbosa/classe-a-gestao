<template>
    <Modal ref="modalRef" max-width="sm" v-slot="{ close }">
        <Head :title="titulo" />

        <TituloCard :titulo="titulo"></TituloCard>

        <div class="mb-4 mt-4 flex items-center justify-center rounded bg-blue-200 p-2 font-bold text-blue-500">
            <i class="mdi mdi-alert-box text-[22px]"></i>
            <div class="ml-2">Apenas documentos válidos serão exibidos</div>
        </div>

        <form @submit.prevent="downloadLoteDocumentos">
            <template v-for="documento of documentos" :key="documento.id">
                <div class="flex items-center gap-2">
                    <Checkbox
                        v-model="form.documento_ids"
                        :inputId="documento.id.toString()"
                        name="documento"
                        :value="documento.id"
                    />
                    <label :for="documento.id">{{ documento.nome_original }}</label>
                </div>
                <div class="mb-4 flex px-4 text-sm font-light">
                    Valido até: {{ dateLocale(documento.data_validade) }}
                </div>
            </template>

            <div class="mt-4 flex justify-end gap-2">
                <Button label="Cancelar" severity="secondary" @click="close" />
                <Button label="Download" type="submit" :loading="downloading" />
            </div>
        </form>
    </Modal>
</template>

<script setup>
import TituloCard from "@/Components/TituloCard.vue";
import { dateLocale } from "@/Utils/dateUtils";
import { Head, useForm } from "@inertiajs/vue3";
import { Modal } from "@inertiaui/modal-vue";
import axios from "axios";

const props = defineProps({
    evento: Object,
    documentos: Array,
});

const titulo = "Download de documentos";

const form = useForm({
    documento_ids: props.documentos?.map((doc) => doc.id) ?? [],
});

function _downloadLoteDocumentos() {
    form.get(route("documentos-internos.lote-download"));
}

const downloading = ref(false);
const downloadLoteDocumentos = async () => {
    try {
        downloading.value = true;
        const response = await axios.get(route("documentos-internos.lote-download"), {
            params: {
                documento_ids: form.documento_ids,
            },
            responseType: "blob", // Importante para downloads
        });

        // Criar URL para o Blob
        const url = window.URL.createObjectURL(new Blob([response.data]));

        // Criar um link temporário e disparar o download
        const link = document.createElement("a");
        link.href = url;
        link.setAttribute("download", "arquivos.zip"); // Define o nome do arquivo
        document.body.appendChild(link);
        link.click();

        // Remover o link após o download
        link.remove();
        window.URL.revokeObjectURL(url);
    } catch (error) {
        console.error("Erro ao baixar o arquivo:", error);
    } finally {
        downloading.value = false;
    }
};
</script>
