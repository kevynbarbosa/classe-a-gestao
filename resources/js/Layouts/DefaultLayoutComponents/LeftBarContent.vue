<template>
    <div>
        <!-- Logo -->
        <img class="my-4 h-12 w-auto m-auto" src="/assets/logo-with-text.png" alt="Logo" />

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
                icon="mdi mdi-file-document-multiple"
                label="Documentação"
                :href="route('artistas.index')"
                :active="route().current('artistas')"
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
    </div>
</template>

<script setup>
import NavLink from "@/Components/LeftMenu/NavLink.vue";
import NavTitle from "@/Components/LeftMenu/NavTitle.vue";
import { onMounted } from "vue";

const props = defineProps([]);

onMounted(() => {
    // Mounted
});
</script>
