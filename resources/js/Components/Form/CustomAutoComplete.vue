<template>
    <AutoComplete
        v-model="inputModel"
        :suggestions="listaFiltrada"
        @complete="pesquisar"
        v-bind="$attrs"
        @option-select="valorAlterado"
    />

    <div>model: {{ model }}</div>
</template>

<script setup>
const props = defineProps({
    lista: { type: Array, required: true, default: [] },
    campoPesquisa: { type: String, default: "nome" },
    emitField: { type: String, default: "id" },
});

const model = defineModel();

const inputModel = ref(null);
const itemSelecionado = ref(null);
const listaFiltrada = ref([]);
const pesquisar = (event) => {
    setTimeout(() => {
        if (!event.query.trim().length) {
            listaFiltrada.value = [...props.lista];
        } else {
            listaFiltrada.value = props.lista.filter((cidade) => {
                return cidade[props.campoPesquisa].toLowerCase().includes(event.query.toLowerCase());
            });
        }
    }, 250);
};

const valorAlterado = (event) => {
    model.value = event.value[props.emitField];
};

watch(
    () => model.value,
    () => {
        inputModel.value = props.lista.find((item) => {
            return item[props.emitField] === model.value;
        });
    },
    { immediate: true },
);
</script>
