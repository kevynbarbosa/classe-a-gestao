<template>
    <div>
        <Head title="Vendedores" />

        <Menu ref="menu" id="overlay_menu" :model="menuOpcoes" :popup="true" @hide="eventoSelecionado = null" />

        <div class="card">
            <TituloCard titulo="Vendedores">
                <Button
                    label="Novo vendedor"
                    icon="mdi mdi-plus"
                    @click="novoVendedor"
                    :loading="loadingModal"
                ></Button>
            </TituloCard>

            <WrapDataTable :resourceObject="vendedores" v-model:filters="filters" @pageUpdate="pageUpdate">
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

                <!-- <Column field="field" header="Field" sortable :showFilterMenu="false">
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
                </Column> -->

                <Column field="actions" header="Ações" class="column-right">
                    <template #body="{ data }">
                        <Button
                            icon="mdi mdi-dots-vertical"
                            size="small"
                            severity="secondary"
                            aria-haspopup="true"
                            aria-controls="overlay_menu"
                            @click="abrirMenu(event, data)"
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
import { Head, router } from "@inertiajs/vue3";
import { visitModal } from "@inertiaui/modal-vue";

defineProps({ vendedores: Object });

const filters = ref({
    id: { value: route().queryParams.filter?.id ?? null },
    nome: { value: route().queryParams.filter?.nome ?? null },
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
                    await visitModal(`/vendedor/${item_selecionado.value.id}/edit`);
                    loadingMenu.value = false;
                },
            },
        ],
    },
]);

const loadingModal = ref(false);
const novoVendedor = async () => {
    loadingModal.value = true;
    await visitModal(`/vendedores/create`);
    loadingModal.value = false;
};

const pageUpdate = (queryString) => {
    router.visit(`/vendedores?` + queryString, { preserveScroll: true });
};
</script>
