<template>
    <Head title="Formulário" />

    <div class="card mx-auto max-w-2xl text-center">
        <ApplicationLogo class="h-20" />
    </div>

    <div class="card mx-auto mt-4 max-w-2xl">
        <TituloCard titulo="Olá, bem vindo ao cadastro de contratantes"></TituloCard>

        <p>É necessário o preenchimento do formulário para prosseguir com o fluxo de contratação</p>
    </div>

    <div class="card mx-auto mt-4 max-w-2xl">
        <TituloCard titulo="Preencha as informações para prosseguir com o fluxo de contratação"></TituloCard>

        <form @submit.prevent="submit">
            <div>
                <FloatLabel variant="in">
                    <InputText id="field" class="w-full" size="small" v-model="form.field" variant="filled" />
                    <label for="field">Label</label>
                </FloatLabel>
                <div class="text-red-500" v-if="form.errors.field">{{ form.errors.field }}</div>
            </div>

            <div class="mt-2">
                <FloatLabel variant="in">
                    <InputText id="field" class="w-full" size="small" v-model="form.field" variant="filled" />
                    <label for="field">Label</label>
                </FloatLabel>
                <div class="text-red-500" v-if="form.errors.field">{{ form.errors.field }}</div>
            </div>

            <div class="mt-4 text-center">
                <Button
                    icon="mdi mdi-check"
                    label="Salvar e enviar para análise"
                    type="submit"
                    :loading="form.processing"
                />
            </div>
        </form>
    </div>
</template>

<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import TituloCard from "@/Components/TituloCard.vue";
import EFormLayout from "@/Layouts/EFormLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";

defineOptions({ layout: EFormLayout });

const props = defineProps({ evento: Object });

const form = useForm({
    field: null,
});

function submit() {
    form.post(route("evento-workflow.salvar-contratante-formulario", { evento: props.evento.token_formulario }));
}
</script>
