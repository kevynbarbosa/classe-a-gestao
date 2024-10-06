<template>
    <Modal>
        <Head :title="titulo" />

        <div class="card">
            <TituloCard :titulo="titulo"></TituloCard>
            <form @submit.prevent="submit">
                <div>
                    <InputText type="text" v-model="form.nome" />
                </div>

                <div class="mt-4 flex gap-2">
                    <Button label="Voltar" severity="secondary" icon="mdi mdi-keyboard-backspace" @click="back" />
                    <Button label="Salvar" type="submit" icon="mdi mdi-content-save" />
                </div>
            </form>
        </div>
    </Modal>
</template>

<script setup>
import TituloCard from "@/Components/TituloCard.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { Modal } from "@inertiaui/modal-vue";

const props = defineProps({ artista: Object, updating: Boolean });

const titulo = props.updating ? "Editar artista" : "Novo artista";

const form = useForm({
    nome: props.artista?.nome ?? "",
});

const back = () => window.history.back();
const submit = () => (props.updating ? updateRecord() : addRecord());
const addRecord = () => form.post("/artistas");
const updateRecord = () => form.put(`/artistas/${props.artista.id}`);
</script>
