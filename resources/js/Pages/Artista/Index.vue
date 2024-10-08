<template>
    <Head title="Artistas" />

    <Menu ref="menu" id="overlay_menu" :model="menuOpcoes" :popup="true" @hide="eventoSelecionado = null" />

    <ModalLink href="/artistas/create">Teste de form</ModalLink>

    <div class="card">
        <TituloCard titulo="Artistas">
            <Button label="Novo artista" icon="mdi mdi-plus" @click="novoArtista" :loading="loadingModal"></Button>
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
import { Head } from "@inertiajs/vue3";
import { ModalLink, visitModal } from "@inertiaui/modal-vue";

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
                    // router.visit(`/artistas/${item_selecionado.value.id}/edit`);
                    visitModal(`/artistas/${item_selecionado.value.id}/edit`);
                },
            },
        ],
    },
]);

// const novoArtista = () => router.visit("/artistas/create");
const loadingModal = ref(false);
const novoArtista = async () => {
    loadingModal.value = true;
    await visitModal("/artistas/create");
    loadingModal.value = false;
};
</script>
