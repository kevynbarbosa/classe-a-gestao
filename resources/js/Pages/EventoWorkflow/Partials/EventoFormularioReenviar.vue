<template>
    <div class="text-center">
        Formulário enviado para o e-mail:
        <b>{{ props.evento.email_formulario }}</b>
        às {{ dateTimeLocale(props.evento.formulario_enviado_em) }}
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

        <div v-if="props.evento.token_formulario" class="rounded bg-primary/20 p-2 text-center hover:bg-primary/40">
            <a
                class="underline"
                :href="route('evento-workflow.contratante-formulario', { evento: props.evento.token_formulario })"
                target="_blank"
            >
                {{ route("evento-workflow.contratante-formulario", { evento: props.evento.token_formulario }) }}
            </a>
        </div>
        <div v-else>Não há link gerado para o formulário</div>

        <div class="w-full text-center">
            <Button class="mt-2" label="Copiar link do formulário" icon="mdi mdi-content-copy" @click="copiarLink" />
        </div>
    </Modal>
</template>

<script setup>
import TituloCard from "@/Components/TituloCard.vue";
import { dateTimeLocale } from "@/Utils/dateUtils";
import { useForm } from "@inertiajs/vue3";
import { Modal, ModalLink } from "@inertiaui/modal-vue";
import { useToast } from "primevue/usetoast";
import EnviarFormularioContratante from "./EnviarFormularioContratante.vue";

const props = defineProps({ evento: Object });
const toast = useToast();

const form = useForm({ email_contratante: "" });

function copiarLink() {
    const link = route("evento-workflow.contratante-formulario", { evento: props.evento.token_formulario });
    navigator.clipboard
        .writeText(link)
        .then(() => {
            toast.add({
                severity: "success",
                summary: "Link copiado",
                detail: "Link copiado para a área de transferência",
                life: 3000,
            });
        })
        .catch((err) => {
            console.error("Erro ao copiar link: ", err);
            toast.add({
                severity: "error",
                summary: "Erro",
                detail: "Ocorreu um erro ao copiar o link",
                life: 3000,
            });
        });
}
</script>
