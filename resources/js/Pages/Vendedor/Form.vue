<template>
    <Modal ref="modalRef" max-width="sm">
        <Head :title="titulo" />

        <TituloCard :titulo="titulo"></TituloCard>

        <form @submit.prevent="submit" autocomplete="off">
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
                        <InputText id="cpf" class="w-full" size="small" v-model="form.cpf" variant="filled" />
                        <label for="cpf">CPF</label>
                    </FloatLabel>
                    <div class="text-red-500" v-if="form.errors.cpf">{{ form.errors.cpf }}</div>
                </div>

                <div>
                    <FloatLabel variant="in">
                        <InputText id="rg" class="w-full" size="small" v-model="form.rg" variant="filled" />
                        <label for="rg">RG</label>
                    </FloatLabel>
                    <div class="text-red-500" v-if="form.errors.rg">{{ form.errors.rg }}</div>
                </div>

                <div>
                    <FloatLabel variant="in">
                        <InputText
                            id="data_nascimento"
                            class="w-full"
                            size="small"
                            v-model="form.data_nascimento"
                            variant="filled"
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
import { Head, useForm } from "@inertiajs/vue3";
import { Modal } from "@inertiaui/modal-vue";

const props = defineProps({ vendedor: Object, updating: Boolean, errors: Object });

const titulo = props.updating ? "Editar vendedor" : "Novo vendedor";

const modalRef = ref(null);
const salvando = ref(false);

const form = useForm({
    nome_completo: props.vendedor?.nome_completo ?? "",
    cpf: props.vendedor?.cpf ?? "",
    rg: props.vendedor?.rg ?? "",
    data_nascimento: props.vendedor?.data_nascimento ?? "",
});

const back = () => window.history.back();
const closeModal = () => modalRef.value.close();
const submit = () => (props.updating ? updateRecord() : addRecord());
const addRecord = () => {
    salvando.value = true;
    form.post("/vendedores", {
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
    form.put(`/vendedores/${props.vendedor.id}`, {
        onSuccess() {
            closeModal();
        },
        onFinish() {
            salvando.value = false;
        },
    });
};
</script>
