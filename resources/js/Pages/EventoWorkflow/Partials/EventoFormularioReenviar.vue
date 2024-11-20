<template>
    <div class="text-center">
        Formulário enviado para o e-mail:
        <b>q4m0e@example.com</b>
        às 12:00
    </div>

    <div class="flex justify-center gap-2">
        <ModalLink href="#editar-email">
            <Button label="Alterar e-mail do formulário" icon="mdi mdi-email-edit" />
        </ModalLink>

        <ModalLink href="#link-formulario">
            <Button label="Copiar link do formulário" icon="mdi mdi-content-copy" severity="info" />
        </ModalLink>
    </div>

    <Modal name="editar-email" max-width="sm">
        <TituloCard titulo="Editar email do contratante"></TituloCard>

        <EnviarFormularioContratante :evento="evento" />
    </Modal>

    <Modal name="link-formulario" max-width="sm">
        <TituloCard titulo="Link do formulário"></TituloCard>

        <div>https://example.com</div>

        <div class="w-full text-center">
            <Button class="mt-2" label="Copiar link do formulário" icon="mdi mdi-content-copy" @click="copiarLink" />
        </div>
    </Modal>
</template>

<script setup>
import TituloCard from "@/Components/TituloCard.vue";
import { useForm } from "@inertiajs/vue3";
import { Modal, ModalLink } from "@inertiaui/modal-vue";
import { useToast } from "primevue/usetoast";
import EnviarFormularioContratante from "./EnviarFormularioContratante.vue";

const props = defineProps({ evento: Object });
const toast = useToast();

const form = useForm({ email_contratante: "" });

function copiarLink() {
    toast.add({
        severity: "success",
        summary: "Link copiado",
        detail: "Link copiada para a área de transferência",
        life: 3000,
    });
}
</script>
