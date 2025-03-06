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
            <div class="grid grid-cols-2 gap-2">
                <!-- Dados basicos -->
                <FieldWrap class="col-span-2" v-model="form" field="nome_completo" label="Nome completo" />
                <FieldWrap v-model="form" field="cpf_cnpj" label="CNPJ" cnpj />
                <FieldWrap v-model="form" field="rg" label="RG (incluir órgão emissor e pontuações)" />

                <!-- Endereço -->
                <div class="col-span-2 my-2 pl-2 text-center font-bold">Endereço do contratante</div>
                <FieldWrap v-model="form" field="cep" label="CEP" cep />
                <FieldWrap v-model="form" field="endereco" label="Endereço" />
                <FieldWrap v-model="form" field="numero" label="Número" />
                <FieldWrap v-model="form" field="complemento" label="Complemento" />
                <FieldWrap v-model="form" field="bairro" label="Bairro" />
                <FieldWrap v-model="form" field="cidade" label="Cidade" />

                <!-- Dados do representante legal -->
                <div class="col-span-2 my-2 pl-2 text-center font-bold">Dados do representante legal</div>
                <FieldWrap
                    class="col-span-2"
                    v-model="form"
                    field="nome_representante_legal"
                    label="Nome do representante legal"
                />
                <FieldWrap
                    v-model="form"
                    field="telefone_representante_legal"
                    label="Telefone do representante legal"
                    phone
                />
                <FieldWrap v-model="form" field="cpf_representante_legal" label="CPF do representante legal" cpf />
                <FieldWrap v-model="form" field="rg_representante_legal" label="RG do representante legal" />
                <FieldWrap v-model="form" field="cep_representante_legal" label="CEP" cep />
                <FieldWrap v-model="form" field="endereco_representante_legal" label="Endereço" />
                <FieldWrap v-model="form" field="numero_representante_legal" label="Número" />
                <FieldWrap v-model="form" field="complemento_representante_legal" label="Complemento" />
                <FieldWrap v-model="form" field="bairro_representante_legal" label="Bairro" />
                <FieldWrap v-model="form" field="cidade_representante_legal" label="Cidade" />
            </div>

            <ValidationResultDisplay :form="form" />

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
import FieldWrap from "@/Components/Form/FieldWrap.vue";
import ValidationResultDisplay from "@/Components/Form/ValidationResultDisplay.vue";
import TituloCard from "@/Components/TituloCard.vue";
import EFormLayout from "@/Layouts/EFormLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";

defineOptions({ layout: EFormLayout });

const props = defineProps({ evento: Object, contratante: Object });

const form = useForm("EventoWorkflowFormularioContratante", {
    nome_completo: props.contratante?.nome_completo ?? null,
    cpf_cnpj: props.contratante?.cpf_cnpj ?? null,
    rg: props.contratante?.rg ?? null,
    cep: props.contratante?.cep ?? null,
    endereco: props.contratante?.endereco ?? null,
    numero: props.contratante?.numero ?? null,
    complemento: props.contratante?.complemento ?? null,
    bairro: props.contratante?.bairro ?? null,
    cidade: props.contratante?.cidade ?? null,
    nome_representante_legal: props.contratante?.nome_representante_legal ?? null,
    cpf_representante_legal: props.contratante?.cpf_representante_legal ?? null,
    rg_representante_legal: props.contratante?.rg_representante_legal ?? null,
    cep_representante_legal: props.contratante?.cep_representante_legal ?? null,
    endereco_representante_legal: props.contratante?.endereco_representante_legal ?? null,
    numero_representante_legal: props.contratante?.numero_representante_legal ?? null,
    complemento_representante_legal: props.contratante?.complemento_representante_legal ?? null,
    bairro_representante_legal: props.contratante?.bairro_representante_legal ?? null,
    cidade_representante_legal: props.contratante?.cidade_representante_legal ?? null,
    telefone_representante_legal: props.contratante?.telefone_representante_legal ?? null,
});

function submit() {
    form.post(route("evento-workflow.salvar-contratante-formulario", { evento: props.evento.token_formulario }));
}
</script>
