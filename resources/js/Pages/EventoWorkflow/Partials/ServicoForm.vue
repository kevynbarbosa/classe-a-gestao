<template>
    <Modal ref="modalRef" max-width="md">
        <Head :title="titulo" />

        <TituloCard :titulo="titulo"></TituloCard>

        <form @submit.prevent="submit" autocomplete="off">
            <div class="grid grid-cols-1 gap-2">
                <div>
                    <FloatLabel variant="in">
                        <InputText
                            id="descricao"
                            class="w-full"
                            size="small"
                            v-model="form.descricao"
                            variant="filled"
                        />
                        <label for="descricao">Descrição</label>
                    </FloatLabel>
                </div>

                <!-- <div>
                    <FloatLabel variant="in">
                        <CurrencyInput id="valor" class="w-full" size="small" v-model="form.valor" variant="filled" />
                        <label for="valor">Valor</label>
                    </FloatLabel>
                </div> -->

                <FieldWrap v-model="form" field="valor" label="Valor" currency />

                <div
                    v-if="Object.keys(form.errors).length > 0"
                    class="mt-4 flex items-center justify-center rounded bg-red-200 p-2 font-bold text-red-500"
                >
                    <i class="mdi mdi-alert-box text-[22px]"></i>
                    <div>Existem erros de validação</div>
                </div>

                <div class="mt-4 flex justify-end gap-2">
                    <Button label="Cancelar" severity="secondary" @click="closeModal" />
                    <Button label="Salvar" type="submit" :loading="form.processing" />
                </div>
            </div>
        </form>
    </Modal>
</template>

<script setup>
import FieldWrap from "@/Components/Form/FieldWrap.vue";
import TituloCard from "@/Components/TituloCard.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { Modal } from "@inertiaui/modal-vue";

const props = defineProps({ evento: Object, servico: Object, updating: Boolean, errors: Object });

const titulo = props.updating ? "Editar serviço" : "Adicionando serviço";

const modalRef = ref(null);

const form = useForm({
    descricao: props.servico?.descricao ?? "",
    valor: props.servico?.valor ? parseFloat(props.servico?.valor) : null,
});

const closeModal = () => modalRef.value.close();
const submit = () => (props.updating ? updateRecord() : addRecord());

const addRecord = () => {
    form.post(route("evento-servicos.store", { evento: props.evento.id }), {
        onSuccess() {
            closeModal();
        },
    });
};

const updateRecord = () => {
    form.put(route("evento-servicos.update", { evento: props.evento?.id, evento_servico: props.servico?.id }), {
        onSuccess() {
            closeModal();
        },
    });
};
</script>
