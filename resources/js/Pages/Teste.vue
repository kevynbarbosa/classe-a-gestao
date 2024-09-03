<template>
    <DefaultLayout>
        <div class="card flex justify-center">
            <!-- <Toast /> -->
            <Button label="Show" @click="show()" />
        </div>

        <div class="text-center">
            <div v-for="i in 100">Item da lista - {{ i }}</div>
        </div>
    </DefaultLayout>
</template>

<script setup>
import DefaultLayout from "@/Layouts/DefaultLayout.vue";

import { useToast } from "primevue/usetoast";
const toast = useToast();

const show = () => {
    toast.add({ severity: "info", summary: "Info", detail: "Message Content", life: 3000 });
};
</script>
