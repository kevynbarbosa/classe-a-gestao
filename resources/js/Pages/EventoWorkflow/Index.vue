<template>
    <Head title="Detalhes do evento" />

    <div class="card">
        <TituloCard titulo="Detalhes do evento" />

        {{ evento }}
    </div>
</template>

<script setup>
import TituloCard from "@/Components/TituloCard.vue";
import { Head } from "@inertiajs/vue3";

const variable = ref(null);

const props = defineProps({ evento: Object });
</script>
