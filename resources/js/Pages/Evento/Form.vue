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
                        <label for="artista_id">Artista</label>
                    </FloatLabel>
                    <div class="text-red-500" v-if="form.errors.artista_id">{{ form.errors.artista_id }}</div>
                </div>

                <div>
                    <FloatLabel variant="in">
                        <Select
                            id="contratante_id"
                            class="w-full"
                            size="small"
                            v-model="form.contratante_id"
                            :options="contratantes"
                            option-label="nome_completo"
                            option-value="id"
                            variant="filled"
                        />
                        <label for="contratante_id">Contratante</label>
                    </FloatLabel>
                    <div class="text-red-500" v-if="form.errors.contratante_id">{{ form.errors.contratante_id }}</div>
                </div>

                <div>
                    <FloatLabel variant="in">
                        <DatePicker
                            id="data_hora"
                            class="w-full"
                            size="small"
                            v-model="form.data_hora"
                            variant="filled"
                            show-time
                            hourFormat="24"
                            :stepMinute="30"
                        />
                        <label for="data_hora">Data e hora</label>
                    </FloatLabel>
                    <div class="text-red-500" v-if="form.errors.data_hora">{{ form.errors.data_hora }}</div>
                </div>

                <div>
                    <FloatLabel variant="in">
                        <InputText id="cidade" class="w-full" size="small" v-model="form.cidade" variant="filled" />
                        <label for="cidade">Cidade</label>
                    </FloatLabel>
                    <div class="text-red-500" v-if="form.errors.cidade">{{ form.errors.cidade }}</div>
                </div>

                <div>
                    <FloatLabel variant="in">
                        <InputText id="recinto" class="w-full" size="small" v-model="form.recinto" variant="filled" />
                        <label for="recinto">Recinto</label>
                    </FloatLabel>
                    <div class="text-red-500" v-if="form.errors.recinto">{{ form.errors.recinto }}</div>
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
import { parseDateTime } from "@/Utils/dateUtils";
import { Head, useForm } from "@inertiajs/vue3";
import { Modal } from "@inertiaui/modal-vue";

const props = defineProps({ evento: Object, artistas: Array, contratantes: Array, updating: Boolean, errors: Object });

const titulo = props.updating ? "Editar evento" : "Novo evento";

const modalRef = ref(null);
const salvando = ref(false);

const form = useForm({
    artista_id: props.evento?.artista_id ?? "",
    contratante_id: props.evento?.contratante_id ?? "",
    data_hora: props.updating ? parseDateTime(props.evento?.data_hora) : "",
    cidade: props.evento?.cidade ?? "",
    recinto: props.evento?.recinto ?? "",
});

const back = () => window.history.back();
const closeModal = () => modalRef.value.close();
const submit = () => (props.updating ? updateRecord() : addRecord());
const addRecord = () => {
    salvando.value = true;
    form.post("/eventos", {
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
    form.put(`/eventos/${props.evento.id}`, {
        onSuccess() {
            closeModal();
        },
        onFinish() {
            salvando.value = false;
        },
    });
};
</script>
