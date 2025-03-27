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
                    <Step value="2" v-if="form.tipo_pessoa != 'prefeitura'">Dados básicos</Step>
                    <Step value="3" v-if="form.tipo_pessoa != 'prefeitura'">Representante Legal</Step>
                </StepList>

                <StepPanels>
                    <StepPanel v-slot="{ activateCallback }" value="1">
                        <div class="grid grid-cols-2 gap-2">
                            <div class="col-span-2 my-4 flex flex-wrap justify-center gap-4">
                                <div class="flex items-center gap-2">
                                    <RadioButton
                                        v-model="form.tipo_pessoa"
                                        inputId="radio-empresa"
                                        name="tipo_pessoa"
                                        value="pj"
                                    />
                                    <label for="radio-empresa">Empresa privada</label>
                                </div>

                                <div class="flex items-center gap-2">
                                    <RadioButton
                                        v-model="form.tipo_pessoa"
                                        inputId="radio-prefeitura"
                                        name="tipo_pessoa"
                                        value="prefeitura"
                                    />
                                    <label for="radio-prefeitura">Prefeitura</label>
                                </div>
                            </div>

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

                            <FieldWrap v-model="form" field="evento_data_hora" label="Data do evento" datepicker />

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
                                v-if="form.tipo_pessoa != 'prefeitura'"
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
    tipo_pessoa: null,
    artista_pretendido: null,
    valor_combinado: null,
    evento_cidade_id: null,
    evento_recinto: null,
    evento_duracao: null,
    evento_data_hora: null,
    nome_completo: null,
    cpf_cnpj: null,
    rg: null,
    cep: null,
    endereco: null,
    numero: null,
    complemento: null,
    bairro: null,
    cidade_id: null,
    representante_legal_nome: null,
    representante_legal_cpf: null,
    representante_legal_rg: null,
    representante_legal_cep: null,
    representante_legal_endereco: null,
    representante_legal_numero: null,
    representante_legal_complemento: null,
    representante_legal_bairro: null,
    representante_legal_cidade_id: null,
    representante_legal_telefone: null,
    observacoes: null,
});

function submit() {
    form.post(route("evento-workflow.salvar-contratante-formulario-aberto"));
}
</script>
