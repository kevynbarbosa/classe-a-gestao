<template>
    <Head title="Artistas" />

    <Menu ref="menu" id="overlay_menu" :model="menuOpcoes" :popup="true" @hide="eventoSelecionado = null" />

    <div class="card">
        <TituloCard titulo="Artistas">
            <Button label="Novo artista" icon="mdi mdi-plus" @click="novoArtista"></Button>
        </TituloCard>

        <DataTable
            :value="artistas.data"
            paginator
            lazy
            v-model:filters="filters"
            filterDisplay="row"
            :globalFilterFields="['nome']"
            :rowsPerPageOptions="[5, 10, 20, 50]"
            :loading="loadingTable"
            :totalRecords="artistas.meta.total"
            :first="artistas.meta.from"
            :rows="artistas.meta.per_page"
            :sort-field="route().queryParams.sort?.replace('-', '')"
            :sort-order="sortOrder"
            @page="pageUpdate"
            @sort="pageUpdate"
            @filter="pageUpdate"
        >
            <Column field="id" header="ID" sortable :showFilterMenu="false">
                <template #filter="{ filterModel, filterCallback }">
                    <InputText
                        v-model="filterModel.value"
                        type="text"
                        @change="filterCallback()"
                        placeholder="Pesquisar por ID"
                    />
                </template>

                <template #body="{ data }">#{{ data.id }}</template>
            </Column>

            <Column field="nome" header="Artista" sortable :showFilterMenu="false">
                <template #filter="{ filterModel, filterCallback }">
                    <InputText
                        v-model="filterModel.value"
                        type="text"
                        @change="filterCallback()"
                        placeholder="Pesquisar por nome"
                    />
                </template>

                <template #body="{ data }">
                    <Avatar label="KB" shape="circle" />
                    {{ data.nome }}
                </template>
            </Column>

            <Column field="actions" header="Açoes" class="column-right">
                <template #body="{ data }">
                    <Button
                        icon="mdi mdi-dots-vertical"
                        size="small"
                        severity="secondary"
                        aria-haspopup="true"
                        aria-controls="overlay_menu"
                        @click="abrirMenu($event, data)"
                    />
                </template>
            </Column>
        </DataTable>
    </div>
</template>

<script setup>
import TituloCard from "@/Components/TituloCard.vue";
import { Head, router } from "@inertiajs/vue3";

defineProps({ artistas: Object });

const sortOrder = route().queryParams.sort?.substring(0, 1) == "-" ? -1 : 1;

function novoArtista() {
    router.visit("/artistas/create");
}

// Seção Menu
const menu = ref();
const eventoSelecionado = ref();
const menuOpcoes = ref([
    {
        label: "Ações",
        items: [
            {
                label: "Editar",
                icon: "pi pi-file-edit",
            },

            {
                label: "Anexar documento",
                icon: "pi pi-paperclip",
                command: () => {
                    abrirAnexarDocumentoDialog();
                },
            },
        ],
    },
]);

function abrirMenu(event, data) {
    menu.value.toggle(event);
    eventoSelecionado.value = data;
}

function serialize(obj) {
    var str = [];
    for (var p in obj)
        if (obj.hasOwnProperty(p)) {
            str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
        }
    return str.join("&");
}

const loadingTable = ref(false);
const filters = ref({
    id: { value: route().queryParams.filter?.id ?? null },
    nome: { value: route().queryParams.filter?.nome ?? null },
});

function filterQueryString(obj) {
    const queryString = Object.entries(obj)
        .map(([key, val]) => {
            return `filter[${key}]=${val.value ?? ""}`; // Se o valor for `null`, substituímos por uma string vazia.
        })
        .join("&");

    return queryString;
}

function pageUpdate(params) {
    var queryObject = {};

    if (params.page) {
        queryObject.page = params.page + 1 || 0;
    }

    if (params.perPage) {
        queryObject.perPage = params.rows;
    }

    if (params.sortField) {
        const sortOrderPrefix = params.sortOrder == -1 ? "-" : "";
        queryObject.sort = sortOrderPrefix + params.sortField;
    }

    const queryString = serialize(queryObject);
    const filter = filterQueryString(filters.value);

    loadingTable.value = true;
    router.visit("/artistas?" + queryString + "&" + filter);
}
</script>
