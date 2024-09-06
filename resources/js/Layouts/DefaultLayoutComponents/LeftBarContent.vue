<template>
    <div>
        <!-- Logo -->
        <img class="my-4 h-12 w-auto m-auto" src="assets/logo-with-text.png" alt="Logo" />

        <!-- Menu -->
        <ul class="list-none p-2 m-0">
            <li>
                <!-- Titulo da seção -->
                <NavTitle label="Menu titulo" icon="mdi mdi-white-balance-sunny" />

                <!-- Lista de itens -->
                <ul class="list-none p-0 m-0 overflow-hidden">
                    <!-- Item navegavel (rota) -->
                    <NavLink
                        icon="mdi mdi-white-balance-sunny"
                        label="Dashboard"
                        :href="route('dashboard')"
                        :active="route().current('dashboard')"
                    />
                </ul>
            </li>
        </ul>
    </div>
</template>

<script setup>
import NavLink from "@/Components/LeftMenu/NavLink.vue";
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
