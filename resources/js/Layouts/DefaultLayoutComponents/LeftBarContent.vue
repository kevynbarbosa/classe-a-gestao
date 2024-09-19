<template>
    <div>
        <!-- Logo -->
        <img class="my-4 h-12 w-auto m-auto" src="/assets/logo-with-text.png" alt="Logo" />

        <!-- Menu -->
        <NavTitle label="Menu titulo" icon="mdi mdi-white-balance-sunny">
            <!-- Item navegavel (rota) -->
            <NavLink
                icon="mdi mdi-white-balance-sunny"
                label="Dashboard"
                :href="route('dashboard')"
                :active="route().current('dashboard')"
            />

            <NavSubmenu label="Submenu 1" icon="mdi mdi-view-list">
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
            </NavSubmenu>
        </NavTitle>
    </div>
</template>

<script setup>
import NavLink from "@/Components/LeftMenu/NavLink.vue";
import NavSubmenu from "@/Components/LeftMenu/NavSubmenu.vue";
import NavTitle from "@/Components/LeftMenu/NavTitle.vue";
import { onMounted, ref } from "vue";

const props = defineProps([]);

const items = ref([
    {
        icon: "",
        route: "",
        label: "Item 1",
    },
    {
        icon: "",
        route: "",
        label: "Item 2",
    },
    {
        icon: "",
        route: "",
        label: "Item 3",
    },
    {
        icon: "",
        route: "",
        label: "Item 4",
    },
]);

onMounted(() => {
    // Mounted
});
</script>
