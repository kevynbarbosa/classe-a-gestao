<template>
    <Head title="Artistas" />

    <Menu ref="menu" id="overlay_menu" :model="menuOpcoes" :popup="true" @hide="eventoSelecionado = null" />

    <div class="card">
        <TituloCard titulo="Artistas">
            <Button label="Novo artista" icon="mdi mdi-plus" @click="novoArtista"></Button>
        </TituloCard>

        <WrapDataTable :resourceObject="artistas" v-model:filters="filters">
            <template #paginatorend>
                <Button type="button" icon="mdi mdi-abacus" text />
            </template>

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
        </WrapDataTable>
    </div>
</template>

<script setup>
import WrapDataTable from "@/Components/DataTable/WrapDataTable.vue";
import TituloCard from "@/Components/TituloCard.vue";
import { useTableMenu } from "@/Composables/useTableMenu";
import { Head, router } from "@inertiajs/vue3";

defineProps({ artistas: Object });

const sortOrder = route().queryParams.sort?.substring(0, 1) == "-" ? -1 : 1;

function novoArtista() {
    router.visit("/artistas/create");
}

const menu = useTableMenu();

// Seção Menu
const menu = ref();
const eventoSelecionado = ref();
function abrirMenu(event, data) {
    menu.value.toggle(event);
    eventoSelecionado.value = data;
}
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

const filters = ref({
    id: { value: route().queryParams.filter?.id ?? null },
    nome: { value: route().queryParams.filter?.nome ?? null },
});
</script>
