<template>
    <Modal class="h-screen" ref="modalRef">
        <Head :title="titulo" />

        <TituloCard :titulo="titulo"></TituloCard>

        <div>
            {{ evento }}
        </div>
    </Modal>
</template>

<script setup>
import TituloCard from "@/Components/TituloCard.vue";
import { Head } from "@inertiajs/vue3";
import { Modal } from "@inertiaui/modal-vue";

const props = defineProps({
    evento: Object,
});

const titulo = "Detalhes do evento";

const variable = ref(null);
</script>
