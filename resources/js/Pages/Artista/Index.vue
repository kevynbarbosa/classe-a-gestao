<template>
    <Head title="Artistas" />

    <Menu ref="menu" id="overlay_menu" :model="menuOpcoes" :popup="true" @hide="eventoSelecionado = null" />

    <div class="card">
        <TituloCard titulo="Artistas">
            <Button label="Novo artista" icon="mdi mdi-plus"></Button>
        </TituloCard>

        <DataTable :value="artistas" paginator :rows="5" :rowsPerPageOptions="[2, 5, 10, 20, 50]">
            <Column field="artista" header="Artista" sortable>
                <template #body="{ data }">
                    <Avatar label="KB" shape="circle" />
                    {{ data.nome }}
                </template>
            </Column>

            <Column field="actions" header="" class="column-right">
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
import { Head } from "@inertiajs/vue3";

defineProps({ artistas: Array });

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
</script>
