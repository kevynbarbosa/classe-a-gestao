<template>
    <div>
        <!-- Logo -->
        <ApplicationLogo class="h-12" />

        <div class="my-4 flex justify-center">
            <ModalLink href="#link-formulario">
                <Button label="Link p/ contratantes" icon="mdi mdi-link-variant" />
            </ModalLink>
        </div>

        <!-- Menu -->
        <NavTitle label="Menu">
            <NavLink
                icon="mdi mdi-chart-bar"
                label="Dashboard"
                :href="route('dashboard')"
                :active="route().current('dashboard')"
            />

            <NavLink
                icon="mdi mdi-calendar-blank"
                label="Calendário"
                :href="route('calendario.index')"
                :active="route().current('calendario')"
            />

            <NavLink
                icon="mdi mdi-microphone-variant"
                label="Eventos"
                :href="route('eventos.index')"
                :active="route().current('eventos')"
            />

            <NavLink
                icon="mdi mdi-account-music"
                label="Artistas"
                :href="route('artistas.index')"
                :active="route().current('artistas')"
            />

            <NavLink
                icon="mdi mdi-account-star"
                label="Contratantes"
                :href="route('contratantes.index')"
                :active="route().current('contratantes')"
            />

            <NavLink
                icon="mdi mdi-account-tie"
                label="Vendedores"
                :href="route('vendedores.index')"
                :active="route().current('vendedores')"
            />

            <NavLink
                icon="mdi mdi-file-document-multiple"
                label="Documentação"
                :href="route('documentos-internos.index')"
                :active="route().current('documentos-internos')"
            />

            <!-- <NavLink
                icon="mdi mdi-youtube"
                label="Gestão de campanha"
                :href="route('documentos-internos.index')"
                :active="route().current('documentos-internos')"
            /> -->

            <!-- <NavSubmenu label="Submenu 1" icon="mdi mdi-view-list">
                <NavLink
                    icon="mdi mdi-view-list"
                    label="Item 1"
                    :href="route('dashboard')"
                    :active="route().current('dashboard')"
                />
                <NavSubmenu label="Submenu 2" icon="mdi mdi-view-list">
                    <NavLink
                        icon="mdi mdi-view-list"
                        label="Item 2.1"
                        :href="route('dashboard')"
                        :active="route().current('dashboard')"
                    />
                </NavSubmenu>
            </NavSubmenu> -->
        </NavTitle>

        <Modal name="link-formulario" max-width="sm">
            <TituloCard titulo="Link do formulário"></TituloCard>

            <div class="rounded bg-primary/20 p-2 text-center hover:bg-primary/40">
                <a class="underline" :href="route('evento-workflow.contratante-formulario-aberto')" target="_blank">
                    {{ route("evento-workflow.contratante-formulario-aberto") }}
                </a>
            </div>

            <div class="w-full text-center">
                <Button
                    class="mt-2"
                    label="Copiar link do formulário"
                    icon="mdi mdi-content-copy"
                    @click="copiarLink"
                />
            </div>
        </Modal>
    </div>
</template>

<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import NavLink from "@/Components/LeftMenu/NavLink.vue";
import NavTitle from "@/Components/LeftMenu/NavTitle.vue";
import TituloCard from "@/Components/TituloCard.vue";
import { Modal, ModalLink } from "@inertiaui/modal-vue";
import { useToast } from "primevue/usetoast";
import { onMounted } from "vue";

const props = defineProps([]);

const toast = useToast();
function copiarLink() {
    const link = route("evento-workflow.contratante-formulario-aberto");
    navigator.clipboard
        .writeText(link)
        .then(() => {
            toast.add({
                severity: "success",
                summary: "Link copiado",
                detail: "Link copiado para a área de transferência",
                life: 3000,
            });
        })
        .catch((err) => {
            console.error("Erro ao copiar link: ", err);
            toast.add({
                severity: "error",
                summary: "Erro",
                detail: "Ocorreu um erro ao copiar o link",
                life: 3000,
            });
        });
}

onMounted(() => {
    // Mounted
});
</script>
