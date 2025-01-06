<template>
    <Modal ref="modalRef" max-width="sm">
        <Head :title="titulo" />

        <TituloCard :titulo="titulo"></TituloCard>

        <form @submit.prevent="submit" autocomplete="off">
            <div>
                <FloatLabel variant="in">
                    <InputText id="nome" class="w-full" size="small" v-model="form.nome" variant="filled" />
                    <label for="nome">Nome da categoria</label>
                </FloatLabel>
                <div class="text-red-500" v-if="form.errors.nome">{{ form.errors.nome }}</div>
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
                <Button label="Salvar" type="submit" :loading="form.processing" />
            </div>
        </form>
    </Modal>
</template>

<script setup>
import TituloCard from "@/Components/TituloCard.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { Modal } from "@inertiaui/modal-vue";

const props = defineProps({ categoria: Object, updating: Boolean, errors: Object });

const titulo = "Nova categoria";

const modalRef = ref(null);

const form = useForm({
    nome: props.categoria?.nome ?? "",
});

const back = () => window.history.back();
const closeModal = () => modalRef.value.close();
function submit() {
    form.post("/documentos-internos-categorias", {
        onSuccess: () => closeModal(),
    });
}
</script>
