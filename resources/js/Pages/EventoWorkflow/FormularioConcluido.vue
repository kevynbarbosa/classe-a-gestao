<template>
    <Head title="Formulário" />

    <div class="card mx-auto max-w-2xl text-center">
        <ApplicationLogo class="h-20" />
    </div>

    <div class="card mx-auto mt-4 max-w-2xl">
        <TituloCard titulo="Olá, bem vindo ao cadastro de contratantes"></TituloCard>

        <p>Este formulário já foi respondido ou expirado.</p>
    </div>
</template>

<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import TituloCard from "@/Components/TituloCard.vue";
import EFormLayout from "@/Layouts/EFormLayout.vue";
import { Head } from "@inertiajs/vue3";

defineOptions({ layout: EFormLayout });

const props = defineProps({ evento: Object });
</script>
