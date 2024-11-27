<template>
    <Modal ref="modalRef" max-width="md">
        <Head :title="titulo" />

        <TituloCard :titulo="titulo"></TituloCard>

        <form @submit.prevent="submit" autocomplete="off">
            <div class="my-2 pl-2 text-center font-bold">Dados do artista</div>
            <div class="grid grid-cols-2 gap-2">
                <div class="col-span-2">
                    <FloatLabel variant="in">
                        <InputText id="nome" class="w-full" size="small" v-model="form.nome" variant="filled" />
                        <label for="nome">Nome do artista</label>
                    </FloatLabel>
                    <div class="text-red-500" v-if="form.errors.nome">{{ form.errors.nome }}</div>
                </div>

                <div class="col-span-2">
                    <FloatLabel variant="in">
                        <InputText
                            id="razao_social"
                            class="w-full"
                            size="small"
                            v-model="form.razao_social"
                            variant="filled"
                        />
                        <label for="razao_social">Razão social</label>
                    </FloatLabel>
                    <div class="text-red-500" v-if="form.errors.razao_social">{{ form.errors.razao_social }}</div>
                </div>

                <div>
                    <FloatLabel variant="in">
                        <InputText id="cnpj" class="w-full" size="small" v-model="form.cnpj" variant="filled" />
                        <label for="cnpj">CNPJ</label>
                    </FloatLabel>
                    <div class="text-red-500" v-if="form.errors.cnpj">{{ form.errors.cnpj }}</div>
                </div>

                <div>
                    <FloatLabel variant="in">
                        <InputText id="email" class="w-full" size="small" v-model="form.email" variant="filled" />
                        <label for="email">E-mail</label>
                    </FloatLabel>
                    <div class="text-red-500" v-if="form.errors.email">{{ form.errors.email }}</div>
                </div>

                <div>
                    <FloatLabel variant="in">
                        <InputText id="telefone" class="w-full" size="small" v-model="form.telefone" variant="filled" />
                        <label for="telefone">Telefone</label>
                    </FloatLabel>
                    <div class="text-red-500" v-if="form.errors.telefone">{{ form.errors.telefone }}</div>
                </div>

                <div>
                    <FloatLabel variant="in">
                        <InputText id="cep" class="w-full" size="small" v-model="form.cep" variant="filled" />
                        <label for="cep">CEP</label>
                    </FloatLabel>
                    <div class="text-red-500" v-if="form.errors.cep">{{ form.errors.cep }}</div>
                </div>

                <div>
                    <FloatLabel variant="in">
                        <InputText id="endereco" class="w-full" size="small" v-model="form.endereco" variant="filled" />
                        <label for="endereco">Endereço</label>
                    </FloatLabel>
                    <div class="text-red-500" v-if="form.errors.endereco">{{ form.errors.endereco }}</div>
                </div>

                <div>
                    <FloatLabel variant="in">
                        <InputText id="numero" class="w-full" size="small" v-model="form.numero" variant="filled" />
                        <label for="numero">Número</label>
                    </FloatLabel>
                    <div class="text-red-500" v-if="form.errors.numero">{{ form.errors.numero }}</div>
                </div>

                <div>
                    <FloatLabel variant="in">
                        <InputText
                            id="complemento"
                            class="w-full"
                            size="small"
                            v-model="form.complemento"
                            variant="filled"
                        />
                        <label for="complemento">Complemento</label>
                    </FloatLabel>
                    <div class="text-red-500" v-if="form.errors.complemento">{{ form.errors.complemento }}</div>
                </div>

                <div>
                    <FloatLabel variant="in">
                        <InputText id="bairro" class="w-full" size="small" v-model="form.bairro" variant="filled" />
                        <label for="bairro">Bairro</label>
                    </FloatLabel>
                    <div class="text-red-500" v-if="form.errors.bairro">{{ form.errors.bairro }}</div>
                </div>

                <div>
                    <FloatLabel variant="in">
                        <CustomAutoComplete
                            id="cidade_id"
                            class="w-full"
                            size="small"
                            v-model="form.cidade_id"
                            :lista="cidades"
                            campo-pesquisa="sem_acentos"
                            option-label="nome"
                            variant="filled"
                            fluid
                        />
                        <label for="cidade_id">Cidade</label>
                    </FloatLabel>
                    <div class="text-red-500" v-if="form.errors.cidade_id">{{ form.errors.cidade_id }}</div>
                </div>
            </div>

            <div class="my-2 pl-2 text-center font-bold">Dados do representante legal</div>

            <div class="grid grid-cols-2 gap-2">
                <div>
                    <FloatLabel variant="in">
                        <InputText
                            id="representante_legal_nome"
                            class="w-full"
                            size="small"
                            v-model="form.representante_legal_nome"
                            variant="filled"
                        />
                        <label for="representante_legal_nome">Nome representante legal</label>
                    </FloatLabel>
                    <div class="text-red-500" v-if="form.errors.representante_legal_nome">
                        {{ form.errors.representante_legal_nome }}
                    </div>
                </div>

                <div>
                    <FloatLabel variant="in">
                        <InputText
                            id="representante_legal_cpf"
                            class="w-full"
                            size="small"
                            v-model="form.representante_legal_cpf"
                            variant="filled"
                        />
                        <label for="representante_legal_cpf">CPF</label>
                    </FloatLabel>
                    <div class="text-red-500" v-if="form.errors.representante_legal_cpf">
                        {{ form.errors.representante_legal_cpf }}
                    </div>
                </div>

                <div>
                    <FloatLabel variant="in">
                        <InputText
                            id="representante_legal_rg"
                            class="w-full"
                            size="small"
                            v-model="form.representante_legal_rg"
                            variant="filled"
                        />
                        <label for="representante_legal_rg">RG (utilize pontuações e órgão emissor)</label>
                    </FloatLabel>
                    <div class="text-red-500" v-if="form.errors.representante_legal_rg">
                        {{ form.errors.representante_legal_rg }}
                    </div>
                </div>

                <div>
                    <FloatLabel variant="in">
                        <InputText
                            id="representante_legal_email"
                            class="w-full"
                            size="small"
                            v-model="form.representante_legal_email"
                            variant="filled"
                        />
                        <label for="representante_legal_email">E-mail</label>
                    </FloatLabel>
                    <div class="text-red-500" v-if="form.errors.representante_legal_email">
                        {{ form.errors.representante_legal_email }}
                    </div>
                </div>
            </div>

            <div class="mt-4 flex justify-end gap-2">
                <Button label="Cancelar" severity="secondary" @click="closeModal" />
                <Button label="Salvar" type="submit" :loading="salvando" />
            </div>
        </form>
    </Modal>
</template>

<script setup>
import CustomAutoComplete from "@/Components/Form/CustomAutoComplete.vue";
import TituloCard from "@/Components/TituloCard.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { Modal } from "@inertiaui/modal-vue";

const props = defineProps({ artista: Object, cidades: Array, updating: Boolean, errors: Object });

const titulo = props.updating ? "Editar artista" : "Novo artista";

const modalRef = ref(null);
const salvando = ref(false);

const form = useForm({
    nome: props.artista?.nome ?? "",
    razao_social: props.artista?.razao_social ?? null,
    cnpj: props.artista?.cnpj ?? null,
    email: props.artista?.email ?? null,
    telefone: props.artista?.telefone ?? null,
    endereco: props.artista?.endereco ?? null,
    numero: props.artista?.numero ?? null,
    complemento: props.artista?.complemento ?? null,
    bairro: props.artista?.bairro ?? null,
    cep: props.artista?.cep ?? null,
    cidade_id: props.artista?.cidade_id ?? null,
    representante_legal_nome: props.artista?.representante_legal_nome ?? null,
    representante_legal_cpf: props.artista?.representante_legal_cpf ?? null,
    representante_legal_rg: props.artista?.representante_legal_rg ?? null,
    representante_legal_email: props.artista?.representante_legal_email ?? null,
});

const back = () => window.history.back();
const closeModal = () => modalRef.value.close();
const submit = () => (props.updating ? updateRecord() : addRecord());
const addRecord = () => {
    salvando.value = true;
    form.post("/artistas", {
        onSuccess() {
            closeModal();
        },
        onFinish() {
            salvando.value = false;
        },
    });
};

const updateRecord = () => {
    salvando.value = true;
    form.put(`/artistas/${props.artista.id}`, {
        onSuccess() {
            closeModal();
        },
        onFinish() {
            salvando.value = false;
        },
    });
};
</script>
