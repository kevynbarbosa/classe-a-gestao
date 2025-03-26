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

        <ValidationResultDisplay :form="form" />

        <form @submit.prevent="submit" autocomplete="off">
            <Stepper value="1">
                <StepList>
                    <Step value="1">Informações do evento</Step>
                    <Step value="2" v-if="contratante?.tipo_pessoa != 'prefeitura'">Dados básicos</Step>
                    <Step value="3" v-if="contratante?.tipo_pessoa != 'prefeitura'">Representante Legal</Step>
                </StepList>
                <StepPanels>
                    <StepPanel v-slot="{ activateCallback }" value="1">
                        <div class="grid grid-cols-2 gap-2">
                            <FieldWrap v-model="form" field="artista_pretendido" label="Artista pretendido" />
                            <FieldWrap
                                v-model="form"
                                field="valor_combinado"
                                label="Valor total do cachê combinado entre as partes"
                                currency
                            />
                            <FieldWrap
                                v-model="form"
                                field="evento_cidade_id"
                                label="Cidade (selecionar na lista)"
                                city
                                :cidades="cidades"
                                autocomplete="off"
                            />

                            <FieldWrap v-model="form" field="evento_recinto" label="Recinto" />

                            <div>
                                <FloatLabel variant="in">
                                    <InputNumber
                                        id="duracao"
                                        class="w-full"
                                        size="small"
                                        v-model="form.evento_duracao"
                                        variant="filled"
                                        suffix=" minutos"
                                    />
                                    <label for="duracao">Duração</label>
                                </FloatLabel>
                                <div class="text-red-500" v-if="form.errors.evento_duracao">
                                    {{ form.errors.evento_duracao }}
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end pt-6">
                            <Button
                                v-if="contratante?.tipo_pessoa != 'prefeitura'"
                                label="Próximo"
                                icon="mdi mdi-arrow-right"
                                iconPos="right"
                                @click="activateCallback('2')"
                            />

                            <Button
                                v-else
                                icon="mdi mdi-check"
                                label="Salvar e enviar para análise"
                                type="submit"
                                :loading="form.processing"
                            />
                        </div>
                    </StepPanel>

                    <StepPanel v-slot="{ activateCallback }" value="2">
                        <!-- Endereço -->
                        <div class="grid grid-cols-2 gap-2">
                            <FieldWrap
                                class="col-span-2"
                                v-model="form"
                                field="nome_completo"
                                label="Nome da empresa contratante"
                            />
                            <FieldWrap v-model="form" field="cpf_cnpj" label="CNPJ da empresa contratante" cnpj />

                            <FieldWrap v-model="form" field="cep" label="CEP" cep />
                            <FieldWrap v-model="form" field="endereco" label="Endereço" />
                            <FieldWrap v-model="form" field="numero" label="Número" />
                            <FieldWrap v-model="form" field="complemento" label="Complemento" />
                            <FieldWrap v-model="form" field="bairro" label="Bairro" />
                            <FieldWrap
                                v-model="form"
                                field="cidade_id"
                                label="Cidade (selecionar na lista)"
                                city
                                :cidades="cidades"
                            />
                        </div>

                        <div class="flex justify-between pt-6">
                            <Button
                                label="Anterior"
                                severity="secondary"
                                icon="mdi mdi-arrow-left"
                                @click="activateCallback('1')"
                            />
                            <Button
                                label="Próximo"
                                icon="mdi mdi-arrow-right"
                                iconPos="right"
                                @click="activateCallback('3')"
                            />
                        </div>
                    </StepPanel>

                    <StepPanel v-slot="{ activateCallback }" value="3">
                        <div class="grid grid-cols-2 gap-2">
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
                            <FieldWrap
                                v-model="form"
                                field="representante_legal_cpf"
                                label="CPF do representante legal"
                                cpf
                            />
                            <FieldWrap
                                v-model="form"
                                field="representante_legal_rg"
                                label="RG do representante legal"
                            />
                            <FieldWrap v-model="form" field="representante_legal_cep" label="CEP" cep />
                            <FieldWrap v-model="form" field="representante_legal_endereco" label="Endereço" />
                            <FieldWrap v-model="form" field="representante_legal_numero" label="Número" />
                            <FieldWrap v-model="form" field="representante_legal_complemento" label="Complemento" />
                            <FieldWrap v-model="form" field="representante_legal_bairro" label="Bairro" />
                            <FieldWrap
                                v-model="form"
                                field="representante_legal_cidade_id"
                                label="Cidade (selecionar na lista)"
                                city
                                :cidades="cidades"
                            />

                            <FieldWrap v-model="form" field="observacoes" label="Observações" />
                        </div>

                        <div class="flex justify-between pt-6">
                            <Button
                                label="Anterior"
                                severity="secondary"
                                icon="mdi mdi-arrow-left"
                                @click="activateCallback('2')"
                            />
                            <Button
                                icon="mdi mdi-check"
                                label="Salvar e enviar para análise"
                                type="submit"
                                :loading="form.processing"
                            />
                        </div>
                    </StepPanel>
                </StepPanels>
            </Stepper>
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
    evento_duracao: props.evento.duracao ?? null,
    nome_completo: props.contratante?.nome_completo ?? null,
    cpf_cnpj: props.contratante?.cpf_cnpj ?? null,
    rg: props.contratante?.rg ?? null,
    cep: props.contratante?.cep ?? null,
    endereco: props.contratante?.endereco ?? null,
    numero: props.contratante?.numero ?? null,
    complemento: props.contratante?.complemento ?? null,
    bairro: props.contratante?.bairro ?? null,
    cidade_id: props.contratante?.cidade_id ?? null,
    representante_legal_nome: props.contratante?.representante_legal_nome ?? null,
    representante_legal_cpf: props.contratante?.representante_legal_cpf ?? null,
    representante_legal_rg: props.contratante?.representante_legal_rg ?? null,
    representante_legal_cep: props.contratante?.representante_legal_cep ?? null,
    representante_legal_endereco: props.contratante?.representante_legal_endereco ?? null,
    representante_legal_numero: props.contratante?.representante_legal_numero ?? null,
    representante_legal_complemento: props.contratante?.representante_legal_complemento ?? null,
    representante_legal_bairro: props.contratante?.representante_legal_bairro ?? null,
    representante_legal_cidade_id: props.contratante?.representante_legal_cidade_id ?? null,
    representante_legal_telefone: props.contratante?.representante_legal_telefone ?? null,
    observacoes: props.evento?.observacoes ?? null,
});

function submit() {
    form.post(route("evento-workflow.salvar-contratante-formulario", { evento: props.evento.token_formulario }));
}
</script>
