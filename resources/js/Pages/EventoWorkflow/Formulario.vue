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
            <div class="flex flex-col gap-3">
                <div>
                    <FloatLabel variant="in">
                        <InputText
                            id="nome_completo"
                            class="w-full"
                            size="small"
                            v-model="form.nome_completo"
                            variant="filled"
                        />
                        <label for="nome_completo">Nome</label>
                    </FloatLabel>
                    <div class="text-red-500" v-if="form.errors.nome_completo">{{ form.errors.nome_completo }}</div>
                </div>

                <div>
                    <FloatLabel variant="in">
                        <InputText id="cpf_cnpj" class="w-full" size="small" v-model="form.cpf_cnpj" variant="filled" />
                        <label for="cpf_cnpj">CPF/CNPJ</label>
                    </FloatLabel>
                    <div class="text-red-500" v-if="form.errors.cpf_cnpj">{{ form.errors.cpf_cnpj }}</div>
                </div>

                <div>
                    <FloatLabel variant="in">
                        <InputText id="rg" class="w-full" size="small" v-model="form.rg" variant="filled" />
                        <label for="rg">RG (incluir órgão emissor e pontuações)</label>
                    </FloatLabel>
                    <div class="text-red-500" v-if="form.errors.rg">{{ form.errors.rg }}</div>
                </div>
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

const props = defineProps({ evento: Object, contratante: Object });

const form = useForm("EventoWorkflowFormularioContratante", {
    nome_completo: props.contratante?.nome_completo ?? null,
    cpf_cnpj: props.contratante?.cpf_cnpj ?? null,
    rg: props.contratante?.rg ?? null,
});

function submit() {
    form.post(route("evento-workflow.salvar-contratante-formulario", { evento: props.evento.token_formulario }));
}
</script>
