<template>
    <div class="text-center">Como deseja enviar a proposta?</div>

    <div class="grid grid-cols-2 gap-2">
        <Button
            label="Editar dados"
            class="mdi mdi-pen"
            icon-class="text-2xl"
            severity="warn"
            @click="editarProposta"
        />
        <Button label="Download e enviar manualmente" icon="mdi mdi-download" icon-class="text-2xl" severity="info" />
        <Button label="E-mail " class="mdi mdi-email-fast" icon-class="text-2xl" />
        <Button label="WhatsApp" class="mdi mdi-whatsapp" icon-class="text-2xl" />
    </div>
</template>

<script setup>
import { router } from "@inertiajs/vue3";

const props = defineProps({ evento: Object });

function editarProposta() {
    router.post(route("evento-workflow.editar-proposta", { evento: props.evento.id }));
}
</script>
