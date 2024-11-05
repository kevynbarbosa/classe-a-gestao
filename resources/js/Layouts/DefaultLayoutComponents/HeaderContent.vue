<template>
    <div>
        <Button
            icon="mdi mdi-menu"
            aria-label="Save"
            @click="emits('toggleSideBar')"
            size="small"
            rounded
            text
            outlined
        />
    </div>

    <div>
        <IconField>
            <InputIcon class="mdi mdi-magnify" />
            <InputText v-model="value" placeholder="Search" size="small" />
        </IconField>
    </div>

    <div class="flex gap-2">
        <Button
            icon="mdi mdi-account-circle"
            @click="router.visit('profile')"
            v-tooltip.left="'Informações de perfil'"
            rounded
            text
            outlined
        />

        <Button
            :icon="isDarkMode ? 'mdi mdi-white-balance-sunny' : 'mdi mdi-weather-night'"
            @click="toggleDarkMode"
            v-tooltip.left="'Alternar entre modo claro e escuro'"
            rounded
            text
            outlined
        />

        <OverlayBadge severity="danger">
            <Button
                icon="mdi mdi-bell"
                @click="emits('toggleRightBar')"
                size="small"
                rounded
                text
                outlined
                v-tooltip.left="'Notificações'"
            ></Button>
        </OverlayBadge>

        <Button icon="mdi mdi-logout" @click="logout" v-tooltip.left="'Sair'" rounded text outlined />
    </div>
</template>

<script setup>
import { router } from "@inertiajs/vue3";

const props = defineProps([]);
const emits = defineEmits(["toggleSideBar", "toggleRightBar"]);

function logout() {
    router.visit("/logout", { method: "post" });
}

function setDarkMode() {
    const element = document.querySelector("html");
    element.classList.add("dark-mode-active");
}

function setLightMode() {
    const element = document.querySelector("html");
    element.classList.remove("dark-mode-active");
}

function toggleDarkMode() {
    const element = document.querySelector("html");
    element.classList.toggle("dark-mode-active");

    checkDarkMode();
    localStorage.setItem("theme", isDarkMode.value ? "dark" : "light");
}

const isDarkMode = ref(false);
function checkDarkMode() {
    isDarkMode.value = document.documentElement.classList.contains("dark-mode-active");
    localStorage.setItem("theme", isDarkMode.value ? "dark" : "light");
}

function loadTheme() {
    const savedTheme = localStorage.getItem("theme");

    if (savedTheme == "dark") {
        setDarkMode();
    } else {
        setLightMode();
    }

    checkDarkMode();
}

const value = ref("");

onMounted(() => {
    loadTheme();
});
</script>
