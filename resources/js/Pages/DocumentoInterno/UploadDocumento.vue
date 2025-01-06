<template>
    <Modal ref="modalRef" max-width="sm">
        <Head :title="titulo" />

        <TituloCard :titulo="titulo"></TituloCard>

        <form @submit.prevent="submit" autocomplete="off"></form>
    </Modal>
</template>

<script setup>
import TituloCard from "@/Components/TituloCard.vue";
import { Head } from "@inertiajs/vue3";
import { Modal } from "@inertiaui/modal-vue";

const titulo = "Upload de novo documento";
</script>
