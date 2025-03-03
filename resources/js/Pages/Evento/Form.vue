<template>
    <Modal ref="modalRef" max-width="md">
        <Head :title="titulo" />

        <TituloCard :titulo="titulo"></TituloCard>

        <form @submit.prevent="submit" autocomplete="off">
            <div class="grid grid-cols-1 gap-2">
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
                        <Select
                            id="vendedor_id"
                            class="w-full"
                            size="small"
                            v-model="form.vendedor_id"
                            :options="vendedores"
                            option-label="nome_completo"
                            option-value="id"
                            variant="filled"
                        />
                        <label for="vendedor_id">Vendedor</label>
                    </FloatLabel>
                    <div class="text-red-500" v-if="form.errors.vendedor_id">{{ form.errors.vendedor_id }}</div>
                </div>

                <div class="flex flex-wrap gap-4">
                    <div class="flex items-center">
                        <RadioButton
                            v-model="form.evento_internacional"
                            inputId="nacional"
                            name="evento_internacional"
                            :value="0"
                        />
                        <label for="nacional" class="ml-2">Nacional</label>
                    </div>
                    <div class="flex items-center">
                        <RadioButton
                            v-model="form.evento_internacional"
                            inputId="internacional"
                            name="evento_internacional"
                            :value="1"
                        />
                        <label for="internacional" class="ml-2">Internacional</label>
                    </div>
                </div>

                <div v-if="form.evento_internacional == 0">
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

                <div v-if="form.evento_internacional == 1">
                    <FloatLabel variant="in">
                        <InputText
                            id="cidade_exterior"
                            class="w-full"
                            size="small"
                            v-model="form.cidade_exterior"
                            variant="filled"
                        />
                        <label for="cidade_exterior">Digite a cidade e país</label>
                    </FloatLabel>
                    <div class="text-red-500" v-if="form.errors.cidade_exterior">{{ form.errors.cidade_exterior }}</div>
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
                        <InputText id="recinto" class="w-full" size="small" v-model="form.recinto" variant="filled" />
                        <label for="recinto">Recinto</label>
                    </FloatLabel>
                    <div class="text-red-500" v-if="form.errors.recinto">{{ form.errors.recinto }}</div>
                </div>

                <div>
                    <FloatLabel variant="in">
                        <InputText
                            id="duracao"
                            class="w-full"
                            size="small"
                            v-model="form.duracao"
                            variant="filled"
                            v-mask="['##:##']"
                        />
                        <label for="duracao">Duração</label>
                    </FloatLabel>
                    <div class="text-red-500" v-if="form.errors.duracao">{{ form.errors.duracao }}</div>
                </div>

                <div>
                    <FloatLabel variant="in">
                        <InputNumber
                            v-model="form.valor"
                            inputId="currency-br"
                            mode="currency"
                            currency="BRL"
                            locale="pt-BR"
                            :maxFractionDigits="0"
                            fluid
                        />
                        <label for="valor">Valor</label>
                    </FloatLabel>
                    <div class="text-red-500" v-if="form.errors.valor">{{ form.errors.valor }}</div>
                </div>
            </div>

            <div
                v-if="disabledForm"
                class="mt-4 flex items-center justify-center rounded bg-orange-200 p-2 font-bold text-orange-500"
            >
                <i class="mdi mdi-alert-box mr-2 text-[22px]"></i>
                <div>Este evento já foi enviado para o contratante e portanto não poderá ser alterado</div>
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
                <Button label="Salvar" type="submit" :loading="form.processing" :disabled="disabledForm" />
            </div>
        </form>
    </Modal>
</template>

<script setup>
import CustomAutoComplete from "@/Components/Form/CustomAutoComplete.vue";
import TituloCard from "@/Components/TituloCard.vue";
import { parseDateTime } from "@/Utils/dateUtils";
import { Head, useForm } from "@inertiajs/vue3";
import { Modal } from "@inertiaui/modal-vue";

const props = defineProps({
    evento: Object,
    cidades: Array,
    artistas: Array,
    vendedores: Array,
    contratantes: Array,
    updating: Boolean,
    errors: Object,
});

const titulo = props.updating ? "Editar evento" : "Novo evento";

const modalRef = ref(null);

const disabledForm = computed(() => {
    return props.updating && props.evento?.status !== "formulario_pendente";
});

const form = useForm({
    artista_id: props.evento?.artista_id ?? "",
    contratante_id: props.evento?.contratante_id ?? "",
    vendedor_id: props.evento?.vendedor_id ?? "",
    data_hora: props.updating ? parseDateTime(props.evento?.data_hora) : "",
    cidade_id: props.evento?.cidade_id ?? "",
    recinto: props.evento?.recinto ?? "",
    evento_internacional: props.evento?.evento_internacional ?? 0,
    cidade_exterior: props.evento?.cidade_exterior ?? "",
    duracao: props.evento?.duracao ?? "",
    valor: props.evento?.valor ?? null,
});

const back = () => window.history.back();
const closeModal = () => modalRef.value.close();
const submit = () => (props.updating ? updateRecord() : addRecord());
const addRecord = () => {
    form.post("/eventos", {
        onSuccess() {
            closeModal();
        },
    });
};

const updateRecord = () => {
    form.put(`/eventos/${props.evento.id}`, {
        onSuccess() {
            closeModal();
        },
    });
};

const cidadesFiltradas = ref();
const pesquisarCidades = (event) => {
    setTimeout(() => {
        if (!event.query.trim().length) {
            cidadesFiltradas.value = [...props.cidades];
        } else {
            cidadesFiltradas.value = props.cidades.filter((cidade) => {
                return cidade.sem_acentos.toLowerCase().includes(event.query.toLowerCase());
            });
        }
    }, 250);
};
</script>
