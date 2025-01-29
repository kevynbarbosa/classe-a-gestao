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
                <Button label="Download" type="submit" :loading="form.processing" />
            </div>
        </form>
    </Modal>
</template>

<script setup>
import TituloCard from "@/Components/TituloCard.vue";
import { dateLocale } from "@/Utils/dateUtils";
import { Head, useForm } from "@inertiajs/vue3";
import { Modal } from "@inertiaui/modal-vue";

const props = defineProps({
    evento: Object,
    documentos: Array,
});

const titulo = "Download de documentos";

const form = useForm({
    documento_ids: props.documentos?.map((doc) => doc.id) ?? [],
});

function downloadLoteDocumentos() {
    form.get(route("documentos-internos.lote-download"));
}
</script>
