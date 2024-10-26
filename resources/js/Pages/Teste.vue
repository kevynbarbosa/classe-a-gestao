<template>
    <div class="text-center">
        <!-- <div v-for="i in 100">Item da lista - {{ i }}</div> -->

        <FloatLabel variant="in">
            <CustomAutoComplete
                id="cidade"
                class="w-full"
                size="small"
                v-model="cidadeSelecionada"
                :lista="cidades"
                campo-pesquisa="sem_acentos"
                option-label="nome"
                option-value="id"
                variant="filled"
                fluid
            />
            <label for="cidade">Cidade</label>
        </FloatLabel>

        <div>cidadeSelecionada: {{ cidadeSelecionada }}</div>
    </div>
</template>

<script setup>
import CustomAutoComplete from "@/Components/Form/CustomAutoComplete.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { useToast } from "primevue/usetoast";
const toast = useToast();

defineOptions({ layout: GuestLayout });

defineProps({
    cidades: Array,
});

const cidadeSelecionada = ref(null);
</script>
