<template>
    <Modal ref="modalRef" max-width="sm">
        <Head :title="titulo" />

        <TituloCard :titulo="titulo"></TituloCard>

        <form @submit.prevent="submit" autocomplete="off">
            <div class="flex flex-col gap-3">
                <div class="self-center">
                    <SelectButton
                        v-model="form.tipo_pessoa"
                        :options="['Física', 'Jurídica']"
                        aria-labelledby="basic"
                        :invalid="!!form.errors?.tipo_pessoa"
                    />
                    <div class="text-red-500" v-if="form.errors.tipo_pessoa">{{ form.errors.tipo_pessoa }}</div>
                </div>

                <div>
                    <FloatLabel variant="in">
                        <InputText
                            id="nome_completo"
                            class="w-full"
                            size="small"
                            v-model="form.nome_completo"
                            variant="filled"
                            :invalid="!!form.errors?.nome_completo"
                        />
                        <label for="nome_completo">Nome</label>
                    </FloatLabel>
                    <div class="text-red-500" v-if="form.errors.nome_completo">{{ form.errors.nome_completo }}</div>
                </div>

                <div>
                    <FloatLabel variant="in">
                        <InputMask
                            id="cpf_cnpj"
                            class="w-full"
                            v-model="form.cpf_cnpj"
                            :mask="form.tipo_pessoa == 'Jurídica' ? '99.99.999/9999-99' : '999.999.999.99'"
                            variant="filled"
                            :auto-clear="false"
                            :invalid="!!form.errors?.cpf_cnpj"
                        />
                        <label for="cpf_cnpj">{{ form.tipo_pessoa == "Jurídica" ? "CNPJ" : "CPF" }}</label>
                    </FloatLabel>
                    <div class="text-red-500" v-if="form.errors.cpf_cnpj">{{ form.errors.cpf_cnpj }}</div>
                </div>

                <div>
                    <FloatLabel variant="in">
                        <InputText
                            id="rg"
                            class="w-full"
                            size="small"
                            v-model="form.rg"
                            variant="filled"
                            :invalid="!!form.errors?.rg"
                        />
                        <label for="rg">RG</label>
                    </FloatLabel>
                    <div class="text-red-500" v-if="form.errors.rg">{{ form.errors.rg }}</div>
                </div>

                <div>
                    <FloatLabel variant="in">
                        <DatePicker
                            id="data_nascimento"
                            class="w-full"
                            size="small"
                            v-model="form.data_nascimento"
                            dateFormat="dd/MM/yy"
                            variant="filled"
                            :invalid="!!form.errors?.data_nascimento"
                        />
                        <label for="data_nascimento">Data de nascimento</label>
                    </FloatLabel>
                    <div class="text-red-500" v-if="form.errors.data_nascimento">{{ form.errors.data_nascimento }}</div>
                </div>
            </div>

            <div
                v-if="Object.keys(form.errors).length > 0"
                class="mt-4 flex items-center justify-center rounded bg-red-200 p-2 font-bold text-red-500"
            >
                <i class="mdi mdi-alert-box text-[22px]"></i>
                <div>Existem erros de validação</div>
            </div>

            <div class="mt-4 flex justify-end gap-2">
                <Button label="Cancelar" severity="secondary" @click="closeModal" />
                <Button label="Salvar" type="submit" :loading="salvando" />
            </div>
        </form>
    </Modal>
</template>

<script setup>
import TituloCard from "@/Components/TituloCard.vue";
import { parse2Date } from "@/Utils/dateUtils";
import { Head, useForm } from "@inertiajs/vue3";
import { Modal } from "@inertiaui/modal-vue";

const props = defineProps({ contratante: Object, updating: Boolean, errors: Object });

const titulo = props.updating ? "Editar contratante" : "Novo contratante";

const modalRef = ref(null);
const salvando = ref(false);

const form = useForm({
    tipo_pessoa: props.contratante?.tipo_pessoa ?? "",
    nome_completo: props.contratante?.nome_completo ?? "",
    cpf_cnpj: props.contratante?.cpf_cnpj ?? "",
    rg: props.contratante?.rg ?? "",
    data_nascimento: parse2Date(props.contratante?.data_nascimento) ?? "",
});

const back = () => window.history.back();
const closeModal = () => modalRef.value.close();
const submit = () => (props.updating ? updateRecord() : addRecord());
const addRecord = () => {
    salvando.value = true;
    form.post("/contratantes", {
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
    form.put(`/contratantes/${props.contratante.id}`, {
        onSuccess() {
            closeModal();
        },
        onFinish() {
            salvando.value = false;
        },
    });
};
</script>
