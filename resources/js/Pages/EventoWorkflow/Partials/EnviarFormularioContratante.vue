<template>
    <p class="my-1 text-sm text-gray-600">Digite o e-mail do contratante para enviar o link do formulário.</p>

    <form autocomplete="off" @submit.prevent="confirmarEnvio">
        <div>
            <FloatLabel variant="in">
                <InputText
                    id="email_contratante"
                    class="w-full"
                    size="small"
                    v-model="form.email_contratante"
                    variant="filled"
                />
                <label for="email_contratante">Email contratante</label>
            </FloatLabel>
            <div class="text-red-500" v-if="form.errors.email_contratante">{{ form.errors.email_contratante }}</div>
        </div>

        <div class="w-full text-center">
            <Button class="mt-2" label="Enviar link para o contratante" icon="mdi mdi-send" type="submit" />
        </div>
    </form>

    <!-- Modal de confirmação -->
    <Modal name="confirmar-envio" max-width="sm">
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
import TituloCard from "@/Components/TituloCard.vue";
import { useForm } from "@inertiajs/vue3";
import { Modal, visitModal } from "@inertiaui/modal-vue";

const props = defineProps({ evento: Object });

const form = useForm({
    email_contratante: "",
});

function confirmarEnvio() {
    form.errors.email_contratante = null;

    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email_contratante)) {
        form.errors.email_contratante = "O e-mail informado é inválido.";
        return;
    }

    visitModal("#confirmar-envio");
}

function enviarLinkContratante() {
    form.post(route("evento-workflow.enviar-formulario-contratante", { evento: props.evento.id }));
}
</script>
