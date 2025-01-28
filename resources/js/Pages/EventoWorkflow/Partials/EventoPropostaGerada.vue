<template>
    <div class="text-center">Como deseja enviar a proposta?</div>

    <div class="grid grid-cols-2 gap-2">
        <Button
            label="Enviar PDF por E-mail "
            class="mdi mdi-email-fast"
            icon-class="text-2xl"
            severity="info"
            @click="confirmarModal"
        />
        <!-- <Button label="WhatsApp" class="mdi mdi-whatsapp" icon-class="text-2xl" severity="info" /> -->

        <Button
            label="Editar dados"
            class="mdi mdi-pen"
            icon-class="text-2xl"
            severity="warn"
            @click="editarProposta"
        />
    </div>
</template>

<script setup>
import { router } from "@inertiajs/vue3";
import { visitModal } from "@inertiaui/modal-vue";

const props = defineProps({ evento: Object });

function editarProposta() {
    router.post(route("evento-workflow.editar-proposta", { evento: props.evento.id }));
}

function confirmarModal() {
    visitModal(route("evento-workflow.confirmar-proposta-email", { evento: props.evento.id }));
}
</script>
