<template>
    <Modal ref="modalRef" max-width="sm">
        <Head :title="titulo" />

        <TituloCard :titulo="titulo"></TituloCard>

        <form @submit.prevent="submit" autocomplete="off">
            <div class="flex flex-col gap-3">
                <div>
                    <FloatLabel variant="in">
                        <Select
                            id="artista_id"
                            class="w-full"
                            size="small"
                            v-model="form.artista_id"
                            :options="artistas"
                            option-label="nome"
                            option-value="id"
                            variant="filled"
                        />
                        <label for="artista_id">Artista (caso seja referente ao artista)</label>
                    </FloatLabel>
                    <div class="text-red-500" v-if="form.errors.artista_id">{{ form.errors.artista_id }}</div>
                </div>

                <div>
                    <FloatLabel variant="in">
                        <Select
                            id="categoria_id"
                            class="w-full"
                            size="small"
                            v-model="form.categoria_id"
                            :options="categorias"
                            option-label="nome"
                            option-value="id"
                            variant="filled"
                        />
                        <label for="categoria_id">Categoria</label>
                    </FloatLabel>
                    <div class="text-red-500" v-if="form.errors.categoria_id">{{ form.errors.categoria_id }}</div>
                </div>

                <div>
                    <FloatLabel variant="in">
                        <DatePicker
                            id="data_validade"
                            class="w-full"
                            size="small"
                            v-model="form.data_validade"
                            variant="filled"
                        />
                        <label for="data_validade">Valido até</label>
                    </FloatLabel>
                    <div class="text-red-500" v-if="form.errors.data_validade">{{ form.errors.data_validade }}</div>
                </div>

                <div>
                    <input type="file" @input="form.arquivo = $event.target.files[0]" />
                    <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                        {{ form.progress.percentage }}%
                    </progress>

                    <div class="text-red-500" v-if="form.errors.arquivo">{{ form.errors.arquivo }}</div>
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
                <Button label="Salvar" type="submit" :loading="form.processing" />
            </div>
        </form>
    </Modal>
</template>

<script setup>
import TituloCard from "@/Components/TituloCard.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { Modal } from "@inertiaui/modal-vue";

const props = defineProps({ documento: Object, artistas: Array, categorias: Array, updating: Boolean, errors: Object });

const titulo = "Upload de novo documento";

const modalRef = ref(null);

const form = useForm({
    arquivo: props.documento?.arquivo ?? "",
    artista_id: props.documento?.artista_id ?? "",
    categoria_id: props.documento?.categoria_id ?? "",
    data_validade: props.documento?.data_validade ?? "",
});

const closeModal = () => modalRef.value.close();

function submit() {
    form.post("/documentos-internos", {
        onSuccess: () => closeModal(),
    });
}
</script>
