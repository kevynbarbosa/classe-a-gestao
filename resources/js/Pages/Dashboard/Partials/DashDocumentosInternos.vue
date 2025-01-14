<template>
    <div class="card h-min">
        <TituloCard titulo="Documentação interna (avisos)">
            <Button
                label="Link"
                icon="mdi mdi-open-in-new"
                size="small"
                @click="router.visit('/documentos-internos')"
            ></Button>
        </TituloCard>
        <div class="max-h-96 overflow-y-auto">
            <DocumentoCard
                v-for="documento in documentos_internos"
                :key="documento.id"
                :documento="documento"
                dashboard
            />
        </div>
    </div>
</template>

<script setup>
import DocumentoCard from "@/Components/DocumentoInterno/DocumentoCard.vue";
import TituloCard from "@/Components/TituloCard.vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({ documentos_internos: Array });

const variable = ref(null);
</script>
