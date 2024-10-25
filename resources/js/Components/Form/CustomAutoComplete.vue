<template>
    <AutoComplete v-model="itemSelecionado" :suggestions="listaFiltrada" @complete="pesquisar" v-bind="$attrs" />
</template>

<script setup>
const props = defineProps({
    lista: { type: Array },
    campoPesquisa: { type: String, default: "nome" },
});

const itemSelecionado = ref(null);
const listaFiltrada = ref();
const pesquisar = (event) => {
    setTimeout(() => {
        if (!event.query.trim().length) {
            listaFiltrada.value = [...props.lista];
        } else {
            listaFiltrada.value = props.lista.filter((cidade) => {
                return cidade.[props.campoPesquisa].toLowerCase().includes(event.query.toLowerCase());
            });
        }
    }, 250);
};
</script>
