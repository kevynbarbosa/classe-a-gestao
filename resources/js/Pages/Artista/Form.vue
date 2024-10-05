<template>
    <Head :title="titulo" />

    <div class="card">
        <TituloCard :titulo="titulo"></TituloCard>
        <form @submit.prevent="submit">
            <div>
                <InputText type="text" v-model="form.nome" />
            </div>

            <Button class="mt-4" label="Salvar" type="submit" icon="mdi mdi-content-save" />
        </form>
    </div>
</template>

<script setup>
import TituloCard from "@/Components/TituloCard.vue";
import { Head, useForm } from "@inertiajs/vue3";

const props = defineProps({ artista: Object, updating: Boolean });

const titulo = props.updating ? "Editar artista" : "Novo artista";

const form = useForm({
    nome: props.artista?.nome ?? "",
});

const submit = () => (props.updating ? updateRecord() : addRecord());
const addRecord = () => form.post("/artistas");
const updateRecord = () => form.put(`/artistas/${props.artista.id}`);
</script>
