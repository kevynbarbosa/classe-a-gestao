<template>
    <Modal ref="modalRef" max-width="sm">
        <Head :title="titulo" />

        <TituloCard :titulo="titulo"></TituloCard>

        <form @submit.prevent="submit">
            <div>
                <InputText class="w-full" type="text" v-model="form.nome" :invalid="form.errors.nome" />
                <div class="text-red-500" v-if="form.errors.nome">{{ form.errors.nome }}</div>
            </div>

            <div class="mt-4 flex gap-2 justify-end">
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

const props = defineProps({ artista: Object, updating: Boolean, errors: Object });

const titulo = props.updating ? "Editar artista" : "Novo artista";

const modalRef = ref(null);
const salvando = ref(false);

const form = useForm({
    nome: props.artista?.nome ?? "",
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
