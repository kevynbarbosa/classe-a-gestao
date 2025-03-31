<template>
    <p class="my-1 text-center text-sm text-gray-600">Confirme as informações para gerar uma proposta.</p>

    <ValidationResultDisplay :form="form" />

    <form @submit.prevent="gerarPropostaContratante" autocomplete="off">
        <Stepper value="1">
            <StepList>
                <Step value="1">Informações do evento</Step>
                <Step value="2" v-if="evento.contratante?.tipo_pessoa != 'prefeitura'">Contratante</Step>
                <Step value="3" v-if="evento.contratante?.tipo_pessoa != 'prefeitura'">Representante legal</Step>
            </StepList>
            <StepPanels>
                <StepPanel v-slot="{ activateCallback }" value="1">
                    <div class="grid grid-cols-2 gap-2">
                        <div class="col-span-2 py-2">
                            Artista pretendido pelo contratante:
                            <b>{{ evento.artista_pretendido }}</b>
                        </div>

                        <div v-if="evento.observacoes_contratante" class="col-span-2 py-2">
                            Observações:
                            <b>{{ evento.observacoes_contratante }}</b>
                        </div>

                        <FieldWrap
                            v-model="form"
                            field="evento_artista_id"
                            label="Artista"
                            select
                            :select-options="artistas"
                            option-label="nome"
                            option-value="id"
                        />

                        <FieldWrap
                            v-model="form"
                            field="evento_vendedor_id"
                            label="Vendedor"
                            select
                            :select-options="vendedores"
                            option-label="nome_completo"
                            option-value="id"
                        />

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
                            v-if="evento.contratante?.tipo_pessoa != 'prefeitura'"
                            label="Próximo"
                            icon="mdi mdi-arrow-right"
                            iconPos="right"
                            @click="activateCallback('2')"
                        />

                        <Button
                            v-else
                            class="mt-2"
                            label="Gerar proposta"
                            icon="mdi mdi-send"
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

                        <FieldWrap v-model="form" field="telefone" label="Telefone" phone />
                        <FieldWrap v-model="form" field="email" label="E-mail" />

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
                        <FieldWrap v-model="form" field="representante_legal_rg" label="RG do representante legal" />
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

                        <FieldWrap
                            v-model="form"
                            label="Estado civil"
                            field="representante_legal_estado_civil"
                            :error="form.errors.representante_legal_estado_civil"
                            select
                            :options="[
                                { label: 'Solteiro(a)', value: 'solteiro' },
                                { label: 'Casado(a)', value: 'casado' },
                                { label: 'Divorciado(a)', value: 'divorciado' },
                                { label: 'Viúvo(a)', value: 'viuvo' },
                            ]"
                            option-value="value"
                            option-label="label"
                        />

                        <FieldWrap
                            v-model="form"
                            label="Sexo"
                            field="representante_legal_sexo"
                            :error="form.errors.representante_legal_sexo"
                            select
                            :options="[
                                { label: 'Masculino', value: 'M' },
                                { label: 'Feminino', value: 'F' },
                            ]"
                            option-value="value"
                            option-label="label"
                        />
                    </div>

                    <div class="flex justify-between pt-6">
                        <Button
                            label="Anterior"
                            severity="secondary"
                            icon="mdi mdi-arrow-left"
                            @click="activateCallback('2')"
                        />

                        <Button
                            class="mt-2"
                            label="Gerar proposta"
                            icon="mdi mdi-send"
                            type="submit"
                            :loading="form.processing"
                        />
                    </div>
                </StepPanel>
            </StepPanels>
        </Stepper>
    </form>
</template>

<script setup>
import FieldWrap from "@/Components/Form/FieldWrap.vue";
import ValidationResultDisplay from "@/Components/Form/ValidationResultDisplay.vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({ evento: Object, cidades: Array, artistas: Array, vendedores: Array });

const form = useForm("GerarContratoFormulario", {
    valor_combinado: props.evento.valor ? Number(props.evento.valor) : null,
    evento_cidade_id: props.evento.cidade_id ?? null,
    evento_artista_id: props.evento.artista_id ?? null,
    evento_vendedor_id: props.evento.vendedor_id ?? null,
    evento_recinto: props.evento.recinto ?? null,
    evento_duracao: props.evento.duracao ?? null,
    nome_completo: props.evento.contratante?.nome_completo ?? null,
    cpf_cnpj: props.evento.contratante?.cpf_cnpj ?? null,
    telefone: props.evento.contratante?.telefone ?? null,
    email: props.evento.contratante?.email ?? null,
    rg: props.evento.contratante?.rg ?? null,
    cep: props.evento.contratante?.cep ?? null,
    endereco: props.evento.contratante?.endereco ?? null,
    numero: props.evento.contratante?.numero ?? null,
    complemento: props.evento.contratante?.complemento ?? null,
    bairro: props.evento.contratante?.bairro ?? null,
    cidade_id: props.evento.contratante?.cidade_id ?? null,
    representante_legal_nome: props.evento.contratante?.representante_legal_nome ?? null,
    representante_legal_cpf: props.evento.contratante?.representante_legal_cpf ?? null,
    representante_legal_rg: props.evento.contratante?.representante_legal_rg ?? null,
    representante_legal_cep: props.evento.contratante?.representante_legal_cep ?? null,
    representante_legal_endereco: props.evento.contratante?.representante_legal_endereco ?? null,
    representante_legal_numero: props.evento.contratante?.representante_legal_numero ?? null,
    representante_legal_complemento: props.evento.contratante?.representante_legal_complemento ?? null,
    representante_legal_bairro: props.evento.contratante?.representante_legal_bairro ?? null,
    representante_legal_cidade_id: props.evento.contratante?.representante_legal_cidade_id ?? null,
    representante_legal_telefone: props.evento.contratante?.representante_legal_telefone ?? null,
    representante_legal_estado_civil: props.evento.contratante?.representante_legal_estado_civil ?? null,
    representante_legal_sexo: props.evento.contratante?.representante_legal_sexo ?? null,
});

function gerarPropostaContratante() {
    form.post(route("evento-workflow.gerar-proposta", { evento: props.evento.id }));
}
</script>

<style>
.p-steppanel {
    background: inherit;
}
</style>
