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
                <!-- Artista -->
                <div class="col-span-2 my-2 pl-2 text-center font-bold">Informações do evento</div>
                <FieldWrap v-model="form" field="artista_pretendido" label="Artista pretendido" />
                <FieldWrap
                    v-model="form"
                    field="valor_combinado"
                    label="Valor total do cachê combinado entre as partes"
                    currency
                />
                <FieldWrap v-model="form" field="evento_cidade_id" label="Cidade" city :cidades="cidades" />
                <FieldWrap v-model="form" field="evento_recinto" label="Recinto" />

                <!-- Dados basicos -->
                <div class="col-span-2 my-2 pl-2 text-center font-bold">Dados básicos</div>
                <FieldWrap
                    class="col-span-2"
                    v-model="form"
                    field="nome_completo"
                    label="Nome da empresa contratante"
                />
                <FieldWrap v-model="form" field="cpf_cnpj" label="CNPJ da empresa contratante" cnpj />

                <!-- Endereço -->
                <div class="col-span-2 my-2 pl-2 text-center font-bold">Endereço do contratante</div>
                <FieldWrap v-model="form" field="contratante_cep" label="CEP" cep />
                <FieldWrap v-model="form" field="contratante_endereco" label="Endereço" />
                <FieldWrap v-model="form" field="contratante_numero" label="Número" />
                <FieldWrap v-model="form" field="contratante_complemento" label="Complemento" />
                <FieldWrap v-model="form" field="contratante_bairro" label="Bairro" />
                <FieldWrap v-model="form" field="contratante_cidade_id" label="Cidade" city :cidades="cidades" />

                <!-- Dados do representante legal -->
                <div class="col-span-2 my-2 pl-2 text-center font-bold">Dados do representante legal</div>
                <FieldWrap
                    class="col-span-2"
                    v-model="form"
                    field="representante_legal_nome"
                    label="Nome do representante legal"
                />
                <FieldWrap
                    v-model="form"
                    field="representante_legal_telefone"
                    label="Telefone do representante legal"
                    phone
                />
                <FieldWrap v-model="form" field="representante_legal_cpf" label="CPF do representante legal" cpf />
                <FieldWrap v-model="form" field="representante_legal_rg" label="RG do representante legal" />
                <FieldWrap v-model="form" field="representante_legal_cep" label="CEP" cep />
                <FieldWrap v-model="form" field="representante_legal_endereco" label="Endereço" />
                <FieldWrap v-model="form" field="representante_legal_numero" label="Número" />
                <FieldWrap v-model="form" field="representante_legal_complemento" label="Complemento" />
                <FieldWrap v-model="form" field="representante_legal_bairro" label="Bairro" />
                <FieldWrap v-model="form" field="representante_legal_cidade" label="Cidade" city :cidades="cidades" />

                <FieldWrap v-model="form" field="observacoes" label="Observações" />
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

const props = defineProps({ evento: Object, contratante: Object, cidades: Array });

const form = useForm("EventoWorkflowFormularioContratante", {
    artista_pretendido: props.contratante?.artista_pretendido ?? null,
    valor_combinado: props.evento?.valor ?? null,
    evento_cidade_id: props.evento?.cidade_id ?? null,
    evento_recinto: props.evento?.recinto ?? null,
    nome_completo: props.contratante?.nome_completo ?? null,
    contratante_cpf_cnpj: props.contratante?.cpf_cnpj ?? null,
    contratante_rg: props.contratante?.rg ?? null,
    contratante_cep: props.contratante?.cep ?? null,
    contratante_endereco: props.contratante?.endereco ?? null,
    contratante_numero: props.contratante?.numero ?? null,
    contratante_complemento: props.contratante?.complemento ?? null,
    contratante_bairro: props.contratante?.bairro ?? null,
    contratante_cidade: props.contratante?.cidade ?? null,
    representante_legal_nome: props.contratante?.representante_legal_nome ?? null,
    representante_legal_cpf: props.contratante?.representante_legal_cpf ?? null,
    representante_legal_rg: props.contratante?.representante_legal_rg ?? null,
    representante_legal_cep: props.contratante?.representante_legal_cep ?? null,
    representante_legal_endereco: props.contratante?.representante_legal_endereco ?? null,
    representante_legal_numero: props.contratante?.representante_legal_numero ?? null,
    representante_legal_complemento: props.contratante?.representante_legal_complemento ?? null,
    representante_legal_bairro: props.contratante?.representante_legal_bairro ?? null,
    representante_legal_cidade: props.contratante?.representante_legal_cidade ?? null,
    representante_legal_telefone: props.contratante?.representante_legal_telefone ?? null,
});

function submit() {
    form.post(route("evento-workflow.salvar-contratante-formulario", { evento: props.evento.token_formulario }));
}
</script>
