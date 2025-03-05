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
                <div class="col-span-2">
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

                <!-- Endereço -->
                <div class="col-span-2 my-2 pl-2 text-center font-bold">Endereço do contratante</div>
                <FieldWrap v-model="form" field="definir" label="CEP" />
                <FieldWrap v-model="form" field="definir" label="Endereço" />
                <FieldWrap v-model="form" field="definir" label="Número" />
                <FieldWrap v-model="form" field="definir" label="Complemento" />
                <FieldWrap v-model="form" field="definir" label="Bairro" />
                <FieldWrap v-model="form" field="definir" label="Cidade" />

                <!-- Dados do representante legal -->
                <div class="col-span-2 my-2 pl-2 text-center font-bold">Dados do representante legal</div>
                <FieldWrap class="col-span-2" v-model="form" field="definir" label="Nome do representante legal" />
                <FieldWrap v-model="form" field="cpf_representante_legal" label="CPF do representante legal" cpf />
                <FieldWrap v-model="form" field="definir" label="RG do representante legal" />
                <FieldWrap v-model="form" field="cep_representante_legal" label="CEP" cep />
                <FieldWrap v-model="form" field="definir" label="Endereço" />
                <FieldWrap v-model="form" field="definir" label="Número" />
                <FieldWrap v-model="form" field="definir" label="Complemento" />
                <FieldWrap v-model="form" field="definir" label="Bairro" />
                <FieldWrap v-model="form" field="definir" label="Cidade" />
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
import FieldWrap from "@/Components/Form/FieldWrap.vue";
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
