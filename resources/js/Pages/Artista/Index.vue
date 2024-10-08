<template>
    <div>
        <Head title="Artistas" />

        <Menu ref="menu" id="overlay_menu" :model="menuOpcoes" :popup="true" @hide="eventoSelecionado = null" />

        <div class="card">
            <TituloCard titulo="Artistas">
                <Button label="Novo artista" icon="mdi mdi-plus" @click="novoArtista" :loading="loadingModal"></Button>
            </TituloCard>

            <WrapDataTable :resourceObject="artistas" v-model:filters="filters" @pageUpdate="pageUpdate">
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
                        <Avatar :label="iniciaisNome(data.nome)" shape="circle" />
                        {{ data.nome }}
                    </template>
                </Column>

                <Column field="actions" header="Ações" class="column-right">
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
    </div>
</template>

<script setup>
import WrapDataTable from "@/Components/DataTable/WrapDataTable.vue";
import TituloCard from "@/Components/TituloCard.vue";
import { useTableMenu } from "@/Composables/useTableMenu";
import { iniciaisNome } from "@/Utils/stringUtils";
import { Head, router } from "@inertiajs/vue3";
import { visitModal } from "@inertiaui/modal-vue";

defineProps({ artistas: Object });

const filters = ref({
    id: { value: route().queryParams.filter?.id ?? null },
    nome: { value: route().queryParams.filter?.nome ?? null },
});

// Seção Menu
const { menu, item_selecionado, abrirMenu } = useTableMenu();
const menuOpcoes = ref([
    {
        label: "Ações",
        items: [
            {
                label: "Editar",
                icon: "mdi mdi-file-edit",
                command: () => {
                    visitModal(`/artistas/${item_selecionado.value.id}/edit`);
                },
            },
        ],
    },
]);

const loadingModal = ref(false);
const novoArtista = async () => {
    loadingModal.value = true;
    await visitModal("/artistas/create");
    loadingModal.value = false;
};

const pageUpdate = (queryString) => {
    router.visit("/artistas?" + queryString);
};
</script>
