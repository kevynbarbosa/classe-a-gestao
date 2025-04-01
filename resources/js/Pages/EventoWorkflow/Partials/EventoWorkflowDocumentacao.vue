<template>
    <div class="grid grid-cols-2 gap-2">
        <DownloadModelo
            label="Proposta"
            :docxLink="
                route('download-modelo.gerado', { evento: props.evento.id, tipo: 'propostaDocx' }) + '?' + Date.now()
            "
            :pdfLink="
                route('download-modelo.gerado', { evento: props.evento.id, tipo: 'propostaPdf' }) + '?' + Date.now()
            "
        />

        <DownloadModelo
            label="Declarações"
            :docxLink="
                route('download-modelo.gerado', { evento: props.evento.id, tipo: 'declaracoesDocx' }) + '?' + Date.now()
            "
            :pdfLink="
                route('download-modelo.gerado', { evento: props.evento.id, tipo: 'declaracoesPdf' }) + '?' + Date.now()
            "
        />

        <DownloadModelo
            label="Declarações econômicas"
            :docxLink="
                route('download-modelo.gerado', { evento: props.evento.id, tipo: 'declaracoesEconomicasDocx' }) +
                '?' +
                Date.now()
            "
            :pdfLink="
                route('download-modelo.gerado', { evento: props.evento.id, tipo: 'declaracoesEconomicasPdf' }) +
                '?' +
                Date.now()
            "
        />

        <DownloadModelo
            label="Contrato"
            :docxLink="
                route('download-modelo.gerado', { evento: props.evento.id, tipo: 'contratoDocx' }) + '?' + Date.now()
            "
            :pdfLink="
                route('download-modelo.gerado', { evento: props.evento.id, tipo: 'contratoPdf' }) + '?' + Date.now()
            "
        />
    </div>
</template>

<script setup>
import DownloadModelo from "@/Components/Evento/DownloadModelo.vue";

const props = defineProps({ evento: Object });
</script>
