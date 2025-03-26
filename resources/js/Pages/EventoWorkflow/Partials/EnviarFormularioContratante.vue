<template>
    <p class="my-1 text-sm text-gray-600">Digite o e-mail do contratante para enviar o link do formulário.</p>

    <form autocomplete="off" @submit.prevent="confirmarEnvio">
        <div class="grid grid-cols-1 gap-2">
            <FieldWrap v-model="form" field="nome" label="Nome" />

            <FieldWrap v-model="form" field="email_contratante" label="Email contratante" />
        </div>

        <div class="w-full text-center">
            <Button class="mt-2" label="Enviar link para o contratante" icon="mdi mdi-send" type="submit" />
        </div>
    </form>

    <!-- <form autocomplete="off" @submit.prevent="confirmarEnvio">
        <div class="w-full text-center">
            <Button class="mt-2" label="Preenchimento interno" icon="mdi mdi-pencil" severity="info" type="submit" />
        </div>
    </form> -->

    <!-- Modal de confirmação -->
    <Modal ref="modalRef" name="confirmar-envio" max-width="sm">
        <TituloCard titulo="Enviar link para o contratante"></TituloCard>

        <div>
            Confirma o envio do link para o contratante no e-mail:
            <b>{{ form.email_contratante }}</b>
            ?
        </div>

        <div class="w-full text-center">
            <Button
                class="mt-2"
                label="Enviar"
                icon="mdi mdi-send"
                @click="enviarLinkContratante"
                :loading="form.processing"
            />
        </div>
    </Modal>
</template>

<script setup>
import FieldWrap from "@/Components/Form/FieldWrap.vue";
import TituloCard from "@/Components/TituloCard.vue";
import { useForm } from "@inertiajs/vue3";
import { Modal, visitModal } from "@inertiaui/modal-vue";
import { useToast } from "primevue/usetoast";

const props = defineProps({ evento: Object });
const toast = useToast();

const form = useForm({
    nome: props.evento.contratante?.nome_completo ?? "",
    email_contratante: "",
});

const modalRef = ref(null);

function confirmarEnvio() {
    form.errors.email_contratante = null;

    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email_contratante)) {
        form.errors.email_contratante = "O e-mail informado é inválido.";
        return;
    }

    visitModal("#confirmar-envio");
}

function enviarLinkContratante() {
    form.post(route("evento-workflow.enviar-formulario-contratante", { evento: props.evento.id }), {
        onSuccess: () => {
            toast.add({ severity: "success", summary: "Sucesso", detail: "Link enviado", life: 3000 });
        },
        onError: () =>
            toast.add({ severity: "error", summary: "Erro", detail: "Ocorreu um erro ao enviar o link", life: 3000 }),
    });
}
</script>
