<template>
    <Head title="Dashboard" />

    <div class="flex gap-4">
        <div class="card">
            <TituloCard titulo="Documentação interna (avisos)"></TituloCard>
        </div>

        <div class="card">
            <TituloCard titulo="Estatísticas de campanha"></TituloCard>
        </div>
    </div>
</template>

<script setup>
import TituloCard from "@/Components/TituloCard.vue";
import { Head } from "@inertiajs/vue3";

const value = ref("");
</script>
