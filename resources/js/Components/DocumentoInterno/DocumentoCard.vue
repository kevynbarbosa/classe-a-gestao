<template>
    <div
        class="flex min-w-24 max-w-48 cursor-pointer flex-col items-center justify-center gap-1 rounded bg-primary/10 p-2 hover:bg-primary/30 hover:shadow-sm"
    >
        <Button icon="mdi mdi-file-download" size="large" rounded @click="downloadDocumento(documento)"></Button>
        <Tag class="text-sm" :severity="statusValidade.severity">{{ statusValidade.label }}</Tag>
        <div class="text-sm font-bold">Valido até: {{ dateLocale(documento.data_validade) }}</div>
        <div v-if="documento.artista_id" class="text-sm font-light">
            {{ documento.artista.nome }}
        </div>
        <div v-else class="text-sm font-light">Doc interno</div>

        <Tag v-if="dashboard" class="text-sm font-bold" severity="info">{{ documento.categoria.nome }}</Tag>

        <Button
            v-if="!dashboard"
            icon="mdi mdi-delete"
            label="Excluir"
            size="small"
            severity="danger"
            @click="deletarDocumento(documento)"
        ></Button>
    </div>
</template>

<script setup>
import { dateLocale } from "@/Utils/dateUtils";
import { router } from "@inertiajs/vue3";

const props = defineProps({ documento: Object, dashboard: Boolean });

const statusValidade = computed(() => {
    const diferencaDias = calcularDiferencaDias(props.documento.data_validade);
    if (diferencaDias < 0) {
        return { label: "Vencido", severity: "danger" };
    } else if (diferencaDias < 7) {
        return { label: "Próximo a vencer", severity: "warn" };
    } else {
        return { label: "Válido", severity: "success" };
    }
});
function downloadDocumento(documento) {
    window.open(route("documentos-internos.download", documento.id), "_blank");
}

function deletarDocumento(documento) {
    router.delete(route("documentos-internos.destroy", documento.id));
}

function calcularDiferencaDias(dataParametro) {
    const hoje = new Date();
    const data = new Date(dataParametro);
    const diferencaTempo = data - hoje;
    const diferencaDias = Math.floor(diferencaTempo / (1000 * 60 * 60 * 24));
    return diferencaDias;
}
</script>
