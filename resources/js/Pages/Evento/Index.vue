<template>
    <div>
        <Head title="Eventos" />

        <Menu ref="menu" id="overlay_menu" :model="menuOpcoes" :popup="true" @hide="eventoSelecionado = null" />

        <div class="card">
            <TituloCard titulo="Eventos">
                <Button label="Novo evento" icon="mdi mdi-plus" @click="novoEvento" :loading="loadingModal"></Button>
            </TituloCard>

            <WrapDataTable :resourceObject="eventos" v-model:filters="filters" @pageUpdate="pageUpdate">
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

                <Column field="artista.nome" header="Artista" sortable :showFilterMenu="false"></Column>
                <Column
                    field="contratante.nome_completo"
                    header="Contratante"
                    sortable
                    :showFilterMenu="false"
                ></Column>
                <Column field="data_hora" header="Data/Hora" sortable :showFilterMenu="false">
                    <template #body="{ data }">
                        {{ dateTimeLocale(data.data_hora) }}
                    </template>
                </Column>
                <Column field="cidade" header="Cidade" sortable :showFilterMenu="false"></Column>
                <Column field="recinto" header="Recinto" sortable :showFilterMenu="false"></Column>

                <Column field="actions" header="Ações" class="column-right">
                    <template #body="{ data }">
                        <Button
                            icon="mdi mdi-dots-vertical"
                            size="small"
                            severity="secondary"
                            aria-haspopup="true"
                            aria-controls="overlay_menu"
                            @click="abrirMenu($event, data)"
                            :loading="loadingMenu"
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
import { dateTimeLocale } from "@/Utils/dateUtils";
import { Head, router } from "@inertiajs/vue3";
import { visitModal } from "@inertiaui/modal-vue";

defineProps({ eventos: Object });

const filters = ref({
    id: { value: route().queryParams.filter?.id ?? null },
    // nome: { value: route().queryParams.filter?.nome ?? null },
});

// Seção Menu
const loadingMenu = ref(false);
const { menu, item_selecionado, abrirMenu } = useTableMenu();
const menuOpcoes = ref([
    {
        label: "Ações",
        items: [
            {
                label: "Editar",
                icon: "mdi mdi-file-edit",
                command: async () => {
                    loadingMenu.value = true;
                    await visitModal(`/eventos/${item_selecionado.value.id}/edit`);
                    loadingMenu.value = false;
                },
            },
        ],
    },
]);

const loadingModal = ref(false);
const novoEvento = async () => {
    loadingModal.value = true;
    await visitModal(`/eventos/create`);
    loadingModal.value = false;
};

const pageUpdate = (queryString) => {
    router.visit(`/eventos?` + queryString, { preserveScroll: true });
};
</script>
