<template>
    <p class="my-1 text-sm text-gray-600">Digite o e-mail do contratante para enviar o link do formulário.</p>

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
        <Button
            class="mt-2"
            label="Enviar link para o contratante"
            icon="mdi mdi-send"
            @click="enviarLinkContratante"
        />
    </div>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    email_contratante: "",
});

function enviarLinkContratante() {}
</script>
