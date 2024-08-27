<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg bg-blue-400 dark:bg-purple-400">
                    <div class="p-6 text-gray-900">You're logged in!</div>
                </div>
            </div>
        </div>

        <div class="card flex justify-center mb-4">
            <Button label="Check" />
        </div>

        <div class="card flex justify-center mb-4">
            <Select
                v-model="selectedCity"
                :options="cities"
                optionLabel="name"
                placeholder="Select a City"
                class="w-full md:w-56"
            />
        </div>

        <div class="card flex justify-center mb-4">
            <Textarea v-model="value" rows="5" cols="30" />
        </div>

        <div class="card flex justify-center mb-4">
            <Button label="Dark mode" @click="toggleDarkMode" />
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import Button from "primevue/button";
import Select from "primevue/select";
import Textarea from "primevue/textarea";
import { ref } from "vue";

const selectedCity = ref();
const cities = ref([
    { name: "New York", code: "NY" },
    { name: "Rome", code: "RM" },
    { name: "London", code: "LDN" },
    { name: "Istanbul", code: "IST" },
    { name: "Paris", code: "PRS" },
]);

const value = ref("");

function toggleDarkMode() {
    const element = document.querySelector("html");
    element.classList.toggle("dark-mode-active");
}
</script>
